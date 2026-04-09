<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Api;

use Magento\Framework\DataObject;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface OrderSenderServiceInterface
 * Sends order data to ESB system
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 * @api
 */
interface OrderSenderServiceInterface
{
    public const string HEADER_CONTENT_TYPE_KEY = 'Content-Type';
    public const string HEADER_CONTENT_TYPE_VALUE = 'application/json';
    public const string HEADER_X_ESB_SOURCE_KEY = 'X-ESB-Source';
    public const string HEADER_X_ESB_SOURCE_VALUE = 'magento';
    public const string HEADER_X_ESB_TOKEN_KEY = 'X-ESB-Token';

    /**
     * Send order to ESB system
     *
     * @param OrderInterface $order
     * @return DataObject Returns result with success flag and message
     */
    public function execute(OrderInterface $order): DataObject;
}