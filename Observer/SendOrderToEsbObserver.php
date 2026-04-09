<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Observer;

use Magento\Sales\Api\Data\OrderInterface;
use Odykyi\EsbConnector\Api\OrderPublisherServiceInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Odykyi\EsbConnector\Helper\ConfigHelper;

/**
 * Class SendOrderToEsbObserver
 * Listens to checkout order submission and publishes order to queue
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class SendOrderToEsbObserver implements ObserverInterface
{
    /**
     * SendOrderToEsbObserver constructor
     *
     * @param OrderPublisherServiceInterface $orderPublisherService
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        private readonly OrderPublisherServiceInterface $orderPublisherService,
        private readonly ConfigHelper $configHelper
    ) {
    }

    /**
     * Publish order ID to message queue
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        if (!$this->configHelper->isEsbConnectorEnabled()) {
            return;
        }

        $order = $observer->getData('order');
        if (!$order instanceof OrderInterface) {
            return;
        }

        $orderId = $order->getEntityId();
        if ($orderId === null) {
            return;
        }

        $this->orderPublisherService->execute((int)$orderId);
    }
}
