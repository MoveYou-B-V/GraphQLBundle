<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

use Overblog\GraphQLBundle\Configuration\Traits\DefaultValueTrait;
use Overblog\GraphQLBundle\Configuration\Traits\TypeTrait;

class InputFieldConfiguration extends TypeConfiguration
{
    use TypeTrait;
    use DefaultValueTrait;

    protected InputConfiguration $parent;

    public function __construct(string $name, string $type = null, $defaultValue = null)
    {
        $this->name = $name;
        $this->type = $type;
        if (func_num_args() > 2) {
            $this->setDefaultValue($defaultValue);
        }
    }

    public static function create(string $name, string $type = null, $defaultValue = null): InputFieldConfiguration
    {
        if (func_num_args() > 2) {
            return new static($name, $type, $defaultValue);
        }

        return new static($name, $type);
    }

    public function getGraphQLType(): string
    {
        return self::TYPE_INPUT_FIELD;
    }

    public function getParent(): InputConfiguration
    {
        return $this->parent;
    }

    public function setParent(InputConfiguration $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function toArray(): array
    {
        $array = array_filter([
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'extensions' => $this->getExtensionsArray(),
        ]);

        if ($this->hasDefaultValue()) {
            $array['defaultValue'] = $this->defaultValue;
        }

        return $array;
    }
}
