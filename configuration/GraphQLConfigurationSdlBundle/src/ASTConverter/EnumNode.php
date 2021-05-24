<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationSdlBundle\ASTConverter;

use GraphQL\Language\AST\Node;
use Overblog\GraphQLBundle\Configuration\EnumConfiguration;
use Overblog\GraphQLBundle\Configuration\EnumValueConfiguration;
use Overblog\GraphQLBundle\Configuration\TypeConfiguration;

class EnumNode implements NodeInterface
{
    public static function toConfiguration(string $name, Node $node): TypeConfiguration
    {
        $enumConfiguration = EnumConfiguration::get($name)
            ->setDescription(Description::get($node))
            ->addExtensions(Extensions::get($node));

        foreach ($node->values as $value) {
            $valueConfiguration = EnumValueConfiguration::get($value->name->value, $value->name->value)
                ->setDescription(Description::get($value))
                ->setDeprecationReason(Deprecated::get($value))
                ->addExtensions(Extensions::get($value));

            $enumConfiguration->addValue($valueConfiguration);
        }

        return $enumConfiguration;
    }
}
