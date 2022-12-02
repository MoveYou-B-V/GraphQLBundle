<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationMetadataBundle;

use Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\DependencyInjection\OverblogGraphQLConfigurationMetadataExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GraphQLConfigurationMetadataBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new OverblogGraphQLConfigurationMetadataExtension();
    }
}
