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
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 * @api
 */
interface OrderPublisherServiceInterface
{
    public const TOPIC_NAME = 'odykyi.esb.order.sync';

    /**
     * Publish order ID to the message queue
     *
     * @param int $orderId
     * @return void
     */
    public function execute(int $orderId): void;
}
