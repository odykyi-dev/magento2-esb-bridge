<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Model\Queue;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Odykyi\EsbConnector\Api\OrderSenderServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class OrderConsumer
 * Processes order from message queue and sends to ESB
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class OrderConsumer
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var OrderSenderServiceInterface
     */
    private OrderSenderServiceInterface $orderSender;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * OrderConsumer constructor
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderSenderServiceInterface $orderSender
     * @param LoggerInterface $logger
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderSenderServiceInterface $orderSender,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderSender = $orderSender;
        $this->logger = $logger;
    }

    /**
     * Process order from queue
     *
     * @param int $orderId
     * @return void
     * @throws LocalizedException
     */
    public function process(int $orderId): void
    {
        try {
            $order = $this->orderRepository->get($orderId);
            $result = $this->orderSender->execute($order);

            if (!$result instanceof DataObject || !$result->getData('success')) {
                $message = $result instanceof DataObject
                    ? $result->getData('message')
                    : 'Unknown error';

                throw new LocalizedException(__(
                    'Failed to send order %1 to ESB: %2',
                    $orderId,
                    $message
                ));
            }

            $this->logger->info('Order processed successfully', [
                'order_id' => $orderId,
                'event_id' => $result->getData('event_id'),
                'status_code' => $result->getData('status_code'),
            ]);
        } catch (NoSuchEntityException $e) {
            $this->logger->critical('Order not found', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            throw new LocalizedException(__('Order %1 not found', $orderId), $e);
        } catch (\Exception $e) {
            $this->logger->critical('Error processing order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
