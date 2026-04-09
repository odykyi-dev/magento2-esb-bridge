# Odykyi_EsbConnector

[![CI](https://github.com/odykyi-dev/magento2-esb-connector/actions/workflows/ci.yml/badge.svg)](https://github.com/odykyi-dev/magento2-esb-connector/actions)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)](https://www.php.net/)
[![Magento](https://img.shields.io/badge/Magento-2.4.6%2B-blue)](https://magento.com/)

## Опис

Модуль Magento 2 для синхронізації замовлень із зовнішньою платформою ESB (Enterprise Service Bus). Модуль реалізує асинхронну обробку замовлень через чергу повідомлень (RabbitMQ).

## Функціонал

- **Асинхронна обробка**: Замовлення відправляються до ESB через чергу повідомлень, що забезпечує безблокову роботу checkout
- **Трансформація даних**: Конвертація даних замовлення Magento у формат ESB з використанням типізованих DataObject
- **Структуроване логування**: Контекстне логування з ID замовлення, ID події та кодами стану
- **Конфігурування**: Увімкнення/вимкнення синхронізації, налаштування URL API та токену через адмін-панель
- **Обробка помилок**: Комплексна обробка помилок з механізмом повторних спроб для невдалих запитів

## Архітектура

```
Оформлення замовлення
        ↓
Подія checkout_submit_all_after
        ↓
SendOrderToEsbObserver
        ↓
OrderPublisherService → Черга повідомлень (RabbitMQ)
        ↓
OrderConsumer (асинхронно)
        ↓
OrderTransformerService → EsbOrderData (Serializable)
        ↓
OrderSenderService → ESB HTTP API
```

## Встановлення

```bash
composer require odykyi/module-esb-connector
php bin/magento module:enable Odykyi_EsbConnector
php bin/magento setup:upgrade
```

## Конфігурація

1. Перейдіть до **Stores → Configuration → Odykyi Extensions → ESB Connector**
2. Увімкніть модуль
3. Введіть URL ESB API (наприклад, `https://esb.example.com/api`)
4. Введіть API Token

## Вимоги

- PHP 8.2+
- Magento 2.4.6+
- Модулі Magento: Sales, Checkout, MessageQueue

## Ліцензія

[MIT](LICENSE)