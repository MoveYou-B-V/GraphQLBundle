<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Extension\IsPublic;

use Overblog\GraphQLBundle\Configuration\TypeConfiguration;
use Overblog\GraphQLBundle\Extension\Extension;

/**
 * Extension to handle public visibility on fields
 */
class IsPublicExtension extends Extension
{
    public const ALIAS = 'public';
    public const SUPPORTS = [TypeConfiguration::TYPE_FIELD];

    /**
     * {@inheritdoc}
     */
    public function supports(): array
    {
        return self::SUPPORTS;
    }
}
