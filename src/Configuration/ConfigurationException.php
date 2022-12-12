<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

final class ConfigurationException extends RuntimeException
{
    /** @var ConfigurationExceptionType[] */
    protected array $errors = [];

    protected function updateMessage(): void
    {
        $message = sprintf("Found %s error(s) in the GraphQL Configuration:\n", count($this->errors));
        foreach ($this->errors as $error) {
            $type = $error->getType();

            $message .= sprintf("[%s %s] %s\n", $type->getGraphQLType(), $type->getName(), $error->getError());
        }

        $this->message = $message;
    }

    public function addError(TypeConfiguration $type, string $error): void
    {
        $this->errors[] = new ConfigurationExceptionType($type, $error);
        $this->updateMessage();
    }

    public function addViolation(ConstraintViolationInterface $violation): void
    {
        if ($violation->getInvalidValue() instanceof TypeConfiguration) {
            $this->addError($violation->getInvalidValue(), (string) $violation->getMessage());
        }
    }

    public function addViolations(ConstraintViolationList $violations): void
    {
        foreach ($violations as $violation) {
            $this->addViolation($violation);
        }
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}
