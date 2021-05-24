<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

class ScalarConfiguration extends RootTypeConfiguration
{
    protected ?string $scalarType = null;

    protected $serialize = null;
    protected $parseValue = null;
    protected $parseLiteral = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function get(string $name): ScalarConfiguration
    {
        return new static($name);
    }

    public function getGraphQLType(): string
    {
        return self::TYPE_SCALAR;
    }

    public function getScalarType(): ?string
    {
        return $this->scalarType;
    }

    public function setScalarType(string $scalarType): self
    {
        $this->scalarType = $scalarType;

        return $this;
    }

    public function getSerialize()
    {
        return $this->serialize;
    }

    public function setSerialize($serialize): self
    {
        $this->serialize = $serialize;

        return $this;
    }

    public function getParseValue()
    {
        return $this->parseValue;
    }

    public function setParseValue($parseValue): self
    {
        $this->parseValue = $parseValue;

        return $this;
    }

    public function getParseLiteral()
    {
        return $this->parseLiteral;
    }

    public function setParseLiteral($parseLiteral): self
    {
        $this->parseLiteral = $parseLiteral;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'scalarType' => $this->scalarType,
            'serialize' => $this->serialize,
            'parseValue' => $this->parseValue,
            'parseLiteral' => $this->parseLiteral,
            'extensions' => $this->getExtensionsArray(),
        ]);
    }
}
