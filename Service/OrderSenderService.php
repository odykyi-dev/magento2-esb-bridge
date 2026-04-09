<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Service;

use Magento\Framework\HTTP\ClientInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\DataObject;
use Magento\Framework\HTTP\ClientFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Odykyi\EsbConnector\Api\OrderSenderServiceInterface;
use Odykyi\EsbConnector\Api\OrderTransformerServiceInterface;
use Odykyi\EsbConnector\Helper\ConfigHelper;
use Odykyi\EsbConnector\Model\UuidGenerator;
use Psr\Log\LoggerInterface;

/**
 * Class OrderSenderService
 * Sends order data to ESB system via HTTP
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class OrderSenderService implements OrderSenderServiceInterface
{
    /**
     * @var OrderTransformerServiceInterface
     */
    private OrderTransformerServiceInterface $transformerService;

    /**
     * @var UuidGenerator
     */
    private UuidGenerator $uuidGenerator;

    /**
     * @var ConfigHelper
     */
    private ConfigHelper $configHelper;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ClientFactory
     */
    private ClientFactory $httpClientFactory;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * OrderSenderService constructor
     *
     * @param OrderTransformerServiceInterface $transformerService
     * @param UuidGenerator $uuidGenerator
     * @param ConfigHelper $configHelper
     * @param LoggerInterface $logger
     * @param ClientFactory $httpClientFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        OrderTransformerServiceInterface $transformerService,
        UuidGenerator $uuidGenerator,
        ConfigHelper $configHelper,
        LoggerInterface $logger,
        ClientFactory $httpClientFactory,
        SerializerInterface $serializer
    ) {
        $this->transformerService = $transformerService;
        $this->uuidGenerator = $uuidGenerator;
        $this->configHelper = $configHelper;
        $this->logger = $logger;
        $this->httpClientFactory = $httpClientFactory;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function execute(OrderInterface $order): DataObject
    {
        $eventId = $this->uuidGenerator->generate();
        $sourceId = $order->getIncrementId();

        try {
            $endPoint = $this->buildEndpoint($sourceId);
            $request = $this->buildRequest($order, $eventId);
            if ($request === null) {
                return $this->buildErrorResult($sourceId, 'Can\'t create order request');
            }
            $client = $this->httpClientFactory->create();
            $client->setTimeout(10);
            $this->setHeaders($client);

            $client->post($endPoint, $request);

            $status = $client->getStatus();
            $responseBody = $client->getBody();

            return $this->buildResult(
                $status,
                $eventId,
                $sourceId,
                $status >= 200 && $status < 300,
                $responseBody
            );
        } catch (\Exception $e) {
            return $this->buildErrorResult($sourceId, $e->getMessage());
        }
    }

    /**
     * Build endpoint URL
     *
     * @param string $sourceId
     * @return string
     */
    private function buildEndpoint(string $sourceId): string
    {
        $platformCode = strtoupper(self::HEADER_X_ESB_SOURCE_VALUE);
        $url = $this->configHelper->getEsbConnectorApiUrl();
        return $url . "/{$platformCode}/{$sourceId}";
    }

    /**
     * Build request
     *
     * @param OrderInterface $order
     * @param string $eventId
     * @return string|null
     */
    private function buildRequest(OrderInterface $order, string $eventId): ?string
    {
        $esbData = $this->transformerService->execute($order);
        $envelop = ['eventId' => $eventId, 'payload' => $esbData->toArray()];

        $result = $this->serializer->serialize($envelop);
        if (is_bool($result)) {
            return null;
        }
        return $result;
    }

    /**
     * Set HTTP headers
     *
     * @param ClientInterface $client
     * @return void
     */
    private function setHeaders(ClientInterface $client): void
    {
        $client->addHeader(self::HEADER_CONTENT_TYPE_KEY, self::HEADER_CONTENT_TYPE_VALUE);
        $client->addHeader(self::HEADER_X_ESB_SOURCE_KEY, self::HEADER_X_ESB_SOURCE_VALUE);
        $client->addHeader(self::HEADER_X_ESB_TOKEN_KEY, $this->configHelper->getEsbConnectorApiToken());
    }

    /**
     * Build result object
     *
     * @param int $status
     * @param string $eventId
     * @param string $sourceId
     * @param bool $success
     * @param string $responseBody
     * @return DataObject
     */
    private function buildResult(
        int $status,
        string $eventId,
        string $sourceId,
        bool $success,
        string $responseBody
    ): DataObject {
        $result = new DataObject([
            'success' => $success,
            'message' => $success ? 'Order sent successfully' : "ESB returned status: {$status}",
            'status_code' => $status,
            'event_id' => $eventId,
        ]);

        if ($success) {
            $this->logger->info('ESB order sent successfully', [
                'order_increment_id' => $sourceId,
                'event_id' => $eventId,
                'status_code' => $status,
            ]);
        } else {
            $this->logger->error('ESB HTTP error', [
                'order_increment_id' => $sourceId,
                'event_id' => $eventId,
                'status_code' => $status,
                'response_body' => $responseBody,
            ]);
        }

        return $result;
    }

    /**
     * Build error result
     *
     * @param string $sourceId
     * @param string $message
     * @return DataObject
     */
    private function buildErrorResult(string $sourceId, string $message): DataObject
    {
        $result = new DataObject([
            'success' => false,
            'message' => $message,
            'status_code' => 0,
            'event_id' => '',
        ]);

        $this->logger->critical('ESB critical error', [
            'order_increment_id' => $sourceId,
            'error_message' => $message,
        ]);

        return $result;
    }
}
