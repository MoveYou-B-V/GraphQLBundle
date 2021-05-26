<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

use Overblog\GraphQLBundle\Configuration\Traits\CommonTrait;

abstract class TypeConfiguration
{
    use CommonTrait;

    public const TYPE_OBJECT = 'object';
    public const TYPE_FIELD = 'field';
    public const TYPE_ARGUMENT = 'argument';
    public const TYPE_INTERFACE = 'interface';
    public const TYPE_INPUT = 'input';
    public const TYPE_INPUT_FIELD = 'input_field';
    public const TYPE_ENUM = 'enum';
    public const TYPE_UNION = 'union';
    public const TYPE_SCALAR = 'scalar';
    public const TYPE_ENUM_VALUE = 'enum_value';

    public const TYPES = [
        self::TYPE_OBJECT,
        self::TYPE_FIELD,
        self::TYPE_ARGUMENT,
        self::TYPE_INTERFACE,
        self::TYPE_INPUT,
        self::TYPE_INPUT_FIELD,
        self::TYPE_ENUM,
        self::TYPE_UNION,
        self::TYPE_SCALAR,
        self::TYPE_ENUM_VALUE,
    ];

    /**
     * @see https://facebook.github.io/graphql/draft/#sec-Input-and-Output-Types
     */
    public const VALID_INPUT_TYPES = [
        self::TYPE_SCALAR,
        self::TYPE_ENUM,
        self::TYPE_INPUT,
    ];

    public const VALID_OUTPUT_TYPES = [
        self::TYPE_SCALAR,
        self::TYPE_OBJECT,
        self::TYPE_INTERFACE,
        self::TYPE_UNION,
        self::TYPE_ENUM,
    ];

    abstract public function getGraphQLType(): string;

    abstract public function toArray(): array;

    /**
     * @return TypeConfiguration[]
     */
    public function getChildren()
    {
        return [];
    }

    public function getChild(string $name): ?TypeConfiguration
    {
        foreach ($this->getChildren() as $child) {
            if ($child->getName() === $name) {
                return $child;
            }
        }

        return null;
    }

    public function getParent(): ?TypeConfiguration
    {
        return null;
    }

    public function getPath(): string
    {
        $parent = $this;
        $path = [];
        while (null !== $parent) {
            $path[] = $parent->getName();
            $parent = $parent->getParent();
        }

        return implode('.', $path);
    }
}
