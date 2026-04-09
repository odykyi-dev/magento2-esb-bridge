<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Odykyi_EsbConnector',
    __DIR__
);

