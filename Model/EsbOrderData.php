<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Model;

use Magento\Framework\DataObject;
use Odykyi\EsbConnector\Api\Data\EsbOrderDataInterface;

/**
 * Class EsbOrderData
 * Represents order data for ESB integration
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class EsbOrderData extends DataObject implements EsbOrderDataInterface
{
    /**
     * @inheritDoc
     */
    public function getEntityId(): int
    {
        return (int)$this->_getData(self::KEY_ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId(int $value): self
    {
        return $this->setData(self::KEY_ENTITY_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getIncrementId(): string
    {
        return (string)$this->_getData(self::KEY_INCREMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setIncrementId(string $value): self
    {
        return $this->setData(self::KEY_INCREMENT_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return (string)$this->_getData(self::KEY_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $value): self
    {
        return $this->setData(self::KEY_STATUS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getState(): string
    {
        return (string)$this->_getData(self::KEY_STATE);
    }

    /**
     * @inheritDoc
     */
    public function setState(string $value): self
    {
        return $this->setData(self::KEY_STATE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId(): int
    {
        return (int)$this->_getData(self::KEY_STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId(int $value): self
    {
        return $this->setData(self::KEY_STORE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerEmail(): string
    {
        return (string)$this->_getData(self::KEY_CUSTOMER_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerEmail(string $value): self
    {
        return $this->setData(self::KEY_CUSTOMER_EMAIL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCurrencyCode(): string
    {
        return (string)$this->_getData(self::KEY_CURRENCY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCurrencyCode(string $value): self
    {
        return $this->setData(self::KEY_CURRENCY_CODE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getIsVirtual(): bool
    {
        return (bool)$this->_getData(self::KEY_IS_VIRTUAL);
    }

    /**
     * @inheritDoc
     */
    public function setIsVirtual(bool $value): self
    {
        return $this->setData(self::KEY_IS_VIRTUAL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getGrandTotal(): float
    {
        return (float)$this->_getData(self::KEY_GRAND_TOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setGrandTotal(float $value): self
    {
        return $this->setData(self::KEY_GRAND_TOTAL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getSubtotal(): float
    {
        return (float)$this->_getData(self::KEY_SUBTOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setSubtotal(float $value): self
    {
        return $this->setData(self::KEY_SUBTOTAL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getShippingAmount(): float
    {
        return (float)$this->_getData(self::KEY_SHIPPING_AMOUNT);
    }

    /**
     * @inheritDoc
     */
    public function setShippingAmount(float $value): self
    {
        return $this->setData(self::KEY_SHIPPING_AMOUNT, $value);
    }

    /**
     * @inheritDoc
     */
    public function getTaxAmount(): float
    {
        return (float)$this->_getData(self::KEY_TAX_AMOUNT);
    }

    /**
     * @inheritDoc
     */
    public function setTaxAmount(float $value): self
    {
        return $this->setData(self::KEY_TAX_AMOUNT, $value);
    }

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return (array)$this->_getData(self::KEY_ITEMS);
    }

    /**
     * @inheritDoc
     */
    public function setItems(array $value): self
    {
        return $this->setData(self::KEY_ITEMS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getBillingAddress(): ?array
    {
        return $this->_getData(self::KEY_BILLING_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setBillingAddress(?array $value): self
    {
        return $this->setData(self::KEY_BILLING_ADDRESS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getShippingAddress(): ?array
    {
        return $this->_getData(self::KEY_SHIPPING_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setShippingAddress(?array $value): self
    {
        return $this->setData(self::KEY_SHIPPING_ADDRESS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return (string)$this->_getData(self::KEY_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $value): self
    {
        return $this->setData(self::KEY_CREATED_AT, $value);
    }
}
