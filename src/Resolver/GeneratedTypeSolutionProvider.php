<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Resolver;

use Overblog\GraphQLBundle\Configuration\Configuration;
use Overblog\GraphQLBundle\Definition\Builder\TypeFactory;

final class GeneratedTypeSolutionProvider
{
    private array $classNames = [];
    private Configuration $configuration;
    private string $namespace;
    private TypeFactory $typeFactory;

    public function __construct(Configuration $configuration, string $namespace, TypeFactory $typeFactory)
    {
        $this->configuration = $configuration;
        $this->typeFactory = $typeFactory;
        $this->namespace = $namespace;
    }

    public function getSolutionLoader(string $id): ?callable
    {
        $typeClass = $this->getTypeClass($id);
        if (!$typeClass) {
            return null;
        }

        return function () use ($typeClass) {
            return $this->typeFactory->create($typeClass);
        };
    }

    public function hasSolution(string $id): bool
    {
        return !empty($this->getTypeClass($id));
    }

    private function getTypeClass(string $id): ?string
    {
        if (!$this->classNames) {
            $this->loadClasses();
        }

        return $this->classNames[$id] ?? null;
    }

    private function loadClasses(): void
    {
        foreach ($this->configuration->getTypes() as $type) {
            $className = sprintf('%s\\%s', $this->namespace, $type->getClassName());
            $alias = $this->getAlias($className);
            $this->classNames[$className] = $className;
            $this->classNames[$alias] = $className;
        }
    }

    private function getAlias(string $className): string
    {
        $pos = strrpos($className, '\\');
        $portion = false === $pos ? $className : substr($className, $pos + 1);

        return preg_replace('/Type$/', '', $portion);
    }
}
