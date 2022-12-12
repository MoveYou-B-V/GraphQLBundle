<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

class ConfigurationExceptionType
{
    private TypeConfiguration $type;
    private string $error;

    public function __construct(TypeConfiguration $type, string $error)
    {
        $this->type = $type;
        $this->error = $error;
    }

    public function getType(): TypeConfiguration
    {
        return $this->type;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
