<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Service;

use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Odykyi\EsbConnector\Api\Data\EsbOrderDataInterface;
use Odykyi\EsbConnector\Api\Data\EsbOrderDataInterfaceFactory;
use Odykyi\EsbConnector\Api\OrderTransformerServiceInterface;

/**
 * Class OrderTransformerService
 * Transforms Magento order to ESB data object
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class OrderTransformerService implements OrderTransformerServiceInterface
{
    /**
     * OrderTransformerService constructor
     *
     * @param EsbOrderDataInterfaceFactory $esbOrderDataFactory
     */
    public function __construct(
        private readonly EsbOrderDataInterfaceFactory $esbOrderDataFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(OrderInterface $order): EsbOrderDataInterface
    {
        $isOrderVirtual = (bool)$order->getIsVirtual();

        return $this->esbOrderDataFactory->create([
            'data' => [
                EsbOrderDataInterface::KEY_ENTITY_ID => (int)$order->getEntityId(),
                EsbOrderDataInterface::KEY_INCREMENT_ID => $order->getIncrementId(),
                EsbOrderDataInterface::KEY_STATUS => $order->getStatus(),
                EsbOrderDataInterface::KEY_STATE => $order->getState(),
                EsbOrderDataInterface::KEY_STORE_ID => (int)$order->getStoreId(),
                EsbOrderDataInterface::KEY_CUSTOMER_EMAIL => $order->getCustomerEmail(),
                EsbOrderDataInterface::KEY_CURRENCY_CODE => $order->getOrderCurrencyCode(),
                EsbOrderDataInterface::KEY_IS_VIRTUAL => $isOrderVirtual,
                EsbOrderDataInterface::KEY_GRAND_TOTAL => (float)$order->getGrandTotal(),
                EsbOrderDataInterface::KEY_SUBTOTAL => (float)$order->getSubtotal(),
                EsbOrderDataInterface::KEY_SHIPPING_AMOUNT => (float)$order->getShippingAmount(),
                EsbOrderDataInterface::KEY_TAX_AMOUNT => (float)$order->getTaxAmount(),
                EsbOrderDataInterface::KEY_ITEMS => $this->prepareItems($order),
                EsbOrderDataInterface::KEY_BILLING_ADDRESS => $this->prepareAddress($order->getBillingAddress()),
                EsbOrderDataInterface::KEY_SHIPPING_ADDRESS => $isOrderVirtual
                    ? null
                    : $this->prepareAddress($order->getShippingAddress()),
                EsbOrderDataInterface::KEY_CREATED_AT => (string)$order->getCreatedAt(),
            ]
        ]);
    }

    /**
     * Prepare order items
     *
     * @param OrderInterface $order
     * @return array
     */
    private function prepareItems(OrderInterface $order): array
    {
        $items = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $items[] = [
                EsbOrderDataInterface::ITEM_KEY_SKU => $item->getSku(),
                EsbOrderDataInterface::ITEM_KEY_NAME => $item->getName(),
                EsbOrderDataInterface::ITEM_KEY_QTY => (float)$item->getQtyOrdered(),
                EsbOrderDataInterface::ITEM_KEY_PRICE => (float)$item->getPrice(),
                EsbOrderDataInterface::ITEM_KEY_PRODUCT_TYPE => $item->getProductType(),
                EsbOrderDataInterface::ITEM_KEY_IS_VIRTUAL => (bool)$item->getIsVirtual(),
            ];
        }
        return $items;
    }

    /**
     * Prepare billing/shipping address
     *
     * @param OrderAddressInterface|null $address
     * @return array|null
     */
    private function prepareAddress(?OrderAddressInterface $address): ?array
    {
        if (!$address) {
            return null;
        }

        return [
            EsbOrderDataInterface::ADDRESS_KEY_FIRSTNAME => $address->getFirstname(),
            EsbOrderDataInterface::ADDRESS_KEY_LASTNAME => $address->getLastname(),
            EsbOrderDataInterface::ADDRESS_KEY_CITY => $address->getCity(),
            EsbOrderDataInterface::ADDRESS_KEY_POSTCODE => $address->getPostcode(),
            EsbOrderDataInterface::ADDRESS_KEY_COUNTRY => $address->getCountryId(),
            EsbOrderDataInterface::ADDRESS_KEY_STREET => $address->getStreet(),
            EsbOrderDataInterface::ADDRESS_KEY_TELEPHONE => $address->getTelephone(),
        ];
    }
}
