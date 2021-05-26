<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Extension\Builder\Builder;

use InvalidArgumentException;
use Overblog\GraphQLBundle\Configuration\Configuration;
use Overblog\GraphQLBundle\Configuration\FieldConfiguration;
use Overblog\GraphQLBundle\Configuration\InterfaceConfiguration;
use Overblog\GraphQLBundle\Configuration\ObjectConfiguration;
use Overblog\GraphQLBundle\Configuration\TypeConfiguration;
use Overblog\GraphQLBundle\Extension\Builder\BuilderInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use function sprintf;

class RelayConnectionFieldsBuilder implements BuilderInterface
{
    public function supports(TypeConfiguration $typeConfiguration): bool
    {
        return in_array($typeConfiguration->getGraphQLType(), [TypeConfiguration::TYPE_OBJECT, TypeConfiguration::TYPE_INTERFACE]);
    }

    public function getConfiguration(TypeConfiguration $typeConfiguration = null): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('configuration');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('edgeType')->isRequired()->end()
                ->scalarNode('edgeDescription')->default('Edges of the connection')->end()
                ->scalarNode('pageInfoType')->default('PageInfo')->end()
                ->scalarNode('pageInfoDescription')->default('Page info of the connection')->end()
                ->scalarNode('totalCountDescription')->default('Total count of items in the connection.')->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * @param ObjectConfiguration|InterfaceConfiguration $typeConfiguration
     *
     * @throws InvalidArgumentException
     */
    public function updateConfiguration(TypeConfiguration $typeConfiguration, $builderConfiguration, Configuration $builderConfigurationuration): void
    {
        $edges = FieldConfiguration::get('edges', sprintf('[%s]', $builderConfiguration['edgeType']))
            ->setDescription($builderConfiguration['edgeDescription']);

        $pageInfo = FieldConfiguration::get('pageInfo', $builderConfiguration['pageInfoType'])
            ->setDescription($builderConfiguration['pageInfoDescription']);

        $totalCount = FieldConfiguration::get('totalCount', 'Int')
            ->setDescription($builderConfiguration['totalCountDescription']);

        $typeConfiguration->addFields([$edges, $pageInfo, $totalCount]);
    }
}
