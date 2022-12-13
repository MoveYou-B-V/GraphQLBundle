<?php

declare(strict_types=1);

namespace Overblog\GraphQLConfigurationSdlBundle\ASTConverter;

use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\NodeKind;

final class Type
{
    public static function get(Node $node): string
    {
        return self::astTypeNodeToString($node->type);
    }

    public static function astTypeNodeToString(\GraphQL\Language\AST\TypeNode $typeNode): string
    {
        $type = '';
        switch ($typeNode->kind) {
            case NodeKind::NAMED_TYPE:
                $type = $typeNode->name->value;
                break;

            case NodeKind::NON_NULL_TYPE:
                $type = self::astTypeNodeToString($typeNode->type).'!';
                break;

            case NodeKind::LIST_TYPE:
                $type = '['.self::astTypeNodeToString($typeNode->type).']';
                break;
        }

        return $type;
    }
}
