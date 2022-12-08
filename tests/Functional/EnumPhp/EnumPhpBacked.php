<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Tests\Functional\EnumPhp;

/**
 * @requires PHP 8.1
 */
enum EnumPhpBacked: string
{
    case VALUE1 = 'v1';
    case VALUE2 = 'v2';
    case VALUE3 = 'v3';
}
