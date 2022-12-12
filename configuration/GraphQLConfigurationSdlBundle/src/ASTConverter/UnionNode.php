<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationSdlBundle\ASTConverter;

use GraphQL\Language\AST\Node;
use Overblog\GraphQLBundle\Configuration\TypeConfiguration;
use Overblog\GraphQLBundle\Configuration\UnionConfiguration;

class UnionNode implements NodeInterface
{
    public static function toConfiguration(string $name, Node $node): TypeConfiguration
    {
        $unionConfiguration = UnionConfiguration::create($name)
            ->setDescription(Description::get($node))
            ->addExtensions(Extensions::get($node));

        if (!empty($node->types)) {
            $types = [];
            foreach ($node->types as $type) {
                $types[] = Type::astTypeNodeToString($type);
            }
            $unionConfiguration->setTypes($types);
        }

        return $unionConfiguration;
    }
}
