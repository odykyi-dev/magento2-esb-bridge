<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Service;

use Magento\Framework\MessageQueue\PublisherInterface;
use Odykyi\EsbConnector\Api\OrderPublisherServiceInterface;

/**
 * Class OrderPublisherService
 * Publishes order ID to message queue
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class OrderPublisherService implements OrderPublisherServiceInterface
{
    /**
     * OrderPublisherService constructor
     *
     * @param PublisherInterface $publisher
     */
    public function __construct(
        private readonly PublisherInterface $publisher
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(int $orderId): void
    {
        $this->publisher->publish(self::TOPIC_NAME, $orderId);
    }
}
