# Odykyi_EsbConnector

[![CI](https://github.com/odykyi-dev/magento2-esb-connector/actions/workflows/ci.yml/badge.svg)](https://github.com/odykyi-dev/magento2-esb-connector/actions)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)](https://www.php.net/)
[![Magento](https://img.shields.io/badge/Magento-2.4.6%2B-blue)](https://magento.com/)

## Description

Magento 2 module for synchronizing orders with external ESB (Enterprise Service Bus) platform. The module implements asynchronous order processing using message queue (RabbitMQ).

## Features

- **Asynchronous Processing**: Orders are sent to ESB via message queue, ensuring non-blocking checkout flow
- **Data Transformation**: Converts Magento order data to ESB-compatible format using typed DataObject
- **Structured Logging**: Contextual logging with order ID, event ID, and status codes
- **Configurable**: Enable/disable sync, configure API URL and token via admin panel
- **Error Handling**: Comprehensive error handling with retry mechanism for failed requests

## Architecture

```
Checkout Order Placed
        ↓
checkout_submit_all_after Event
        ↓
SendOrderToEsbObserver
        ↓
OrderPublisherService → Message Queue (RabbitMQ)
        ↓
OrderConsumer (async)
        ↓
OrderTransformerService → EsbOrderData (Serializable)
        ↓
OrderSenderService → ESB HTTP API
```

## Installation

```bash
composer require odykyi/module-esb-connector
php bin/magento module:enable Odykyi_EsbConnector
php bin/magento setup:upgrade
```

## Configuration

1. Go to **Stores → Configuration → Odykyi Extensions → ESB Connector**
2. Enable the module
3. Enter ESB API URL (e.g., `https://esb.example.com/api`)
4. Enter API Token

## Requirements

- PHP 8.2+
- Magento 2.4.6+
- Magento modules: Sales, Checkout, MessageQueue

## License

[MIT](LICENSE)