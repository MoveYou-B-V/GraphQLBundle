<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration\Traits;

trait DefaultValueTrait
{
    protected $defaultValue;

    protected bool $isDefaultValueSet = false;

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue(): bool
    {
        return $this->isDefaultValueSet;
    }

    public function setDefaultValue($defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        $this->isDefaultValueSet = true;

        return $this;
    }
}
