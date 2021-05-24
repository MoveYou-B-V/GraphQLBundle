<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Extension\Access;

use Overblog\GraphQLBundle\Configuration\TypeConfiguration;
use Overblog\GraphQLBundle\Extension\Extension;

/**
 * Extension to handle access on fields
 */
class AccessExtension extends Extension
{
    public const ALIAS = 'access';
    public const SUPPORTS = [
        TypeConfiguration::TYPE_FIELD,
    ];

    /**
     * {@inheritdoc}
     */
    public function supports(): array
    {
        return self::SUPPORTS;
    }
}
