<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration\Traits;

use Overblog\GraphQLBundle\Configuration\ExtensionConfiguration;

trait ExtensionTrait
{
    protected array $extensions = [];

    /**
     * @return ExtensionConfiguration[]
     */
    public function getExtensions(string $alias = null): array
    {
        return array_filter($this->extensions, fn (ExtensionConfiguration $extensionConfiguration) => null !== $alias ? $extensionConfiguration->getAlias() === $alias : true);
    }

    /**
     * Check if given extension has been used at leat one time
     */
    public function hasExtension(string $alias): bool
    {
        return count($this->getExtensions($alias)) > 0;
    }

    /**
     * Return the first extension matching
     *
     * @return void
     */
    public function getExtension(string $alias): ?ExtensionConfiguration
    {
        return current($this->getExtensions($alias));
    }

    public function addExtension(ExtensionConfiguration $extensionConfiguration): self
    {
        $this->extensions[] = $extensionConfiguration;

        return $this;
    }

    public function addExtensions(array $extensionConfigurations): self
    {
        foreach ($extensionConfigurations as $extensionConfiguration) {
            $this->addExtension($extensionConfiguration);
        }

        return $this;
    }

    public function getExtensionsArray(): ?array
    {
        if (0 === count($this->extensions)) {
            return null;
        }

        return array_map(fn (ExtensionConfiguration $extensionConfiguration) => $extensionConfiguration->toArray(), $this->extensions);
    }
}
