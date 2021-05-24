<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Extension\Validation;

use Overblog\GraphQLBundle\Configuration\TypeConfiguration;
use Overblog\GraphQLBundle\Extension\Extension;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Extension to handle validation
 */
class ValidationExtension extends Extension
{
    public const ALIAS = 'validation';

    /**
     * Provide a TreeBuilder to process configuration based on type.
     */
    public function getConfiguration(TypeConfiguration $type = null): ?TreeBuilder
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(): array
    {
        return [
            TypeConfiguration::TYPE_OBJECT,
            TypeConfiguration::TYPE_FIELD,
            TypeConfiguration::TYPE_ARGUMENT,
            TypeConfiguration::TYPE_INPUT,
            TypeConfiguration::TYPE_INPUT_FIELD,
        ];
    }
}
