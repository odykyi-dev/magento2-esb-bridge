<?php
/**
 * Copyright (c) 2026. Oleksandr Dykyi (https://github.com/odykyi-dev)
 *
 * MIT License
 */

declare(strict_types=1);

namespace Odykyi\EsbConnector\Model;

use Ramsey\Uuid\Uuid;

/**
 * Class UuidGenerator
 * Generates UUID v4 strings for event identification
 *
 * @category  Odykyi
 * @package   Odykyi_EsbConnector
 * @author    Oleksandr Dykyi <dykyi.oleksandr@gmail.com>
 * @copyright Copyright (c) 2026
 * @license   https://opensource.org/licenses/MIT MIT
 */
class UuidGenerator
{
    /**
     * Generate UUID v4
     *
     * @return string
     */
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}