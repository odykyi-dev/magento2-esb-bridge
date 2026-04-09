<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Api\Data;

/**
 * Interface EsbOrderDataInterface
 * Represents order data for ESB integration
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 * @api
 */
interface EsbOrderDataInterface
{
    public const KEY_ENTITY_ID = 'entity_id';
    public const KEY_INCREMENT_ID = 'increment_id';
    public const KEY_STATUS = 'status';
    public const KEY_STATE = 'state';
    public const KEY_STORE_ID = 'store_id';
    public const KEY_CUSTOMER_EMAIL = 'customer_email';
    public const KEY_CURRENCY_CODE = 'currency_code';
    public const KEY_IS_VIRTUAL = 'is_virtual';
    public const KEY_GRAND_TOTAL = 'grand_total';
    public const KEY_SUBTOTAL = 'subtotal';
    public const KEY_SHIPPING_AMOUNT = 'shipping_amount';
    public const KEY_TAX_AMOUNT = 'tax_amount';
    public const KEY_ITEMS = 'items';
    public const KEY_BILLING_ADDRESS = 'billing_address';
    public const KEY_SHIPPING_ADDRESS = 'shipping_address';
    public const KEY_CREATED_AT = 'created_at';

    public const ITEM_KEY_SKU = 'sku';
    public const ITEM_KEY_NAME = 'name';
    public const ITEM_KEY_QTY = 'qty';
    public const ITEM_KEY_PRICE = 'price';
    public const ITEM_KEY_PRODUCT_TYPE = 'product_type';
    public const ITEM_KEY_IS_VIRTUAL = 'is_virtual';

    public const ADDRESS_KEY_FIRSTNAME = 'firstname';
    public const ADDRESS_KEY_LASTNAME = 'lastname';
    public const ADDRESS_KEY_CITY = 'city';
    public const ADDRESS_KEY_POSTCODE = 'postcode';
    public const ADDRESS_KEY_COUNTRY = 'country';
    public const ADDRESS_KEY_STREET = 'street';
    public const ADDRESS_KEY_TELEPHONE = 'telephone';

    /**
     * Get entity ID
     */
    public function getEntityId(): int;

    /**
     * Set entity ID
     */
    public function setEntityId(int $value): self;

    /**
     * Get increment ID
     */
    public function getIncrementId(): string;

    /**
     * Set increment ID
     */
    public function setIncrementId(string $value): self;

    /**
     * Get order status
     */
    public function getStatus(): string;

    /**
     * Set order status
     */
    public function setStatus(string $value): self;

    /**
     * Get order state
     */
    public function getState(): string;

    /**
     * Set order state
     */
    public function setState(string $value): self;

    /**
     * Get store ID
     */
    public function getStoreId(): int;

    /**
     * Set store ID
     */
    public function setStoreId(int $value): self;

    /**
     * Get customer email
     */
    public function getCustomerEmail(): string;

    /**
     * Set customer email
     */
    public function setCustomerEmail(string $value): self;

    /**
     * Get currency code
     */
    public function getCurrencyCode(): string;

    /**
     * Set currency code
     */
    public function setCurrencyCode(string $value): self;

    /**
     * Get is virtual flag
     */
    public function getIsVirtual(): bool;

    /**
     * Set is virtual flag
     */
    public function setIsVirtual(bool $value): self;

    /**
     * Get grand total
     */
    public function getGrandTotal(): float;

    /**
     * Set grand total
     */
    public function setGrandTotal(float $value): self;

    /**
     * Get subtotal
     */
    public function getSubtotal(): float;

    /**
     * Set subtotal
     */
    public function setSubtotal(float $value): self;

    /**
     * Get shipping amount
     */
    public function getShippingAmount(): float;

    /**
     * Set shipping amount
     */
    public function setShippingAmount(float $value): self;

    /**
     * Get tax amount
     */
    public function getTaxAmount(): float;

    /**
     * Set tax amount
     */
    public function setTaxAmount(float $value): self;

    /**
     * Get items
     */
    public function getItems(): array;

    /**
     * Set items
     */
    public function setItems(array $value): self;

    /**
     * Get billing address
     */
    public function getBillingAddress(): ?array;

    /**
     * Set billing address
     */
    public function setBillingAddress(?array $value): self;

    /**
     * Get shipping address
     */
    public function getShippingAddress(): ?array;

    /**
     * Set shipping address
     */
    public function setShippingAddress(?array $value): self;

    /**
     * Get created at date
     */
    public function getCreatedAt(): string;

    /**
     * Set created at date
     */
    public function setCreatedAt(string $value): self;
}
