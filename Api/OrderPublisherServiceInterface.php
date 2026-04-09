<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Api;

/**
 * Interface OrderPublisherInterface
 * @api
 */
interface OrderPublisherServiceInterface
{
    public const string TOPIC_NAME = 'odykyi.esb.order.sync';

    /**
     * Publish order ID to the message queue
     *
     * @param int $orderId
     * @return void
     */
    public function execute(int $orderId): void;
}
