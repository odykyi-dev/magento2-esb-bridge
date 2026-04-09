<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface;

/**
 * Class ConfigHelper
 * Provides access to ESB Connector configuration settings
 *
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class ConfigHelper extends AbstractHelper
{
    private const XML_PATH_ESB_CONNECTOR_GENERAL_ENABLED = 'esb_connector/general/enabled';
    private const XML_PATH_ESB_CONNECTOR_GENERAL_API_URL = 'esb_connector/general/api_url';
    private const XML_PATH_ESB_CONNECTOR_GENERAL_API_TOKEN = 'esb_connector/general/api_token';

    /**
     * @var EncryptorInterface
     */
    private EncryptorInterface $encryptor;

    /**
     * ConfigHelper constructor
     *
     * @param Context $context
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->encryptor = $encryptor;
    }

    /**
     * Check if ESB Connector is enabled
     *
     * @return bool
     */
    public function isEsbConnectorEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ESB_CONNECTOR_GENERAL_ENABLED);
    }

    /**
     * Get ESB Connector API URL
     *
     * @return string
     */
    public function getEsbConnectorApiUrl(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_ESB_CONNECTOR_GENERAL_API_URL);
    }

    /**
     * Get decrypted ESB Connector API token
     *
     * @return string
     */
    public function getEsbConnectorApiToken(): string
    {
        $value = $this->scopeConfig->getValue(self::XML_PATH_ESB_CONNECTOR_GENERAL_API_TOKEN);
        return $value ? (string)$this->encryptor->decrypt($value) : '';
    }
}
