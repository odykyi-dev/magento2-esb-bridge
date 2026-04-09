<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Api;

use Magento\Sales\Api\Data\OrderInterface;
use Odykyi\EsbConnector\Api\Data\EsbOrderDataInterface;

/**
 * Interface OrderTransformerServiceInterface
 * Transforms Magento order to ESB data object
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 * @api
 */
interface OrderTransformerServiceInterface
{
    /**
     * Transform order to ESB data object
     *
     * @param OrderInterface $order
     * @return EsbOrderDataInterface
     */
    public function execute(OrderInterface $order): EsbOrderDataInterface;
}
