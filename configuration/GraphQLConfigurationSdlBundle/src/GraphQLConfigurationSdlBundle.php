<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationSdlBundle;

use Overblog\GraphQL\Bundle\ConfigurationSdlBundle\DependencyInjection\OverblogGraphQLConfigurationSdlExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GraphQLConfigurationSdlBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new OverblogGraphQLConfigurationSdlExtension();
    }
}
