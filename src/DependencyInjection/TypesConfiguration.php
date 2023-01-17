<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\DependencyInjection;

use Overblog\GraphQLBundle\Config;
use Overblog\GraphQLBundle\Config\Processor\InheritanceProcessor;
use Overblog\GraphQLBundle\Config\TypeDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use function array_keys;
use function array_map;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function preg_match;
use function sprintf;
use function str_replace;

class TypesConfiguration implements ConfigurationInterface
{
    /**
     * @var array<TypeDefinition, string>
     */
    private array $types;

    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('overblog_graphql_types');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $configTypeKeys = array_map(fn ($type) => $this->normalizedConfigTypeKey($type), $this->types);

        $this->addBeforeNormalization($rootNode);

        // @phpstan-ignore-next-line
        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                // config is the unique config entry allowed
                ->beforeNormalization()
                    ->ifTrue(function ($v) use ($configTypeKeys) {
                        if (!empty($v) && is_array($v)) {
                            $keys = array_keys($v);
                            foreach ($configTypeKeys as $configTypeKey) {
                                if (in_array($configTypeKey, $keys)) {
                                    return true;
                                }
                            }
                        }

                        return false;
                    })
                        ->thenInvalid(
                            sprintf(
                                'Don\'t use internal config keys %s, replace it by "config" instead.',
                                implode(', ', $configTypeKeys)
                            )
                        )
                ->end()
                // config is renamed _{TYPE}_config
                ->beforeNormalization()
                    ->ifTrue(fn ($v) => isset($v['type']) && is_string($v['type']))
                    ->then(function ($v) {
                        $key = $this->normalizedConfigTypeKey($v['type']);

                        if (empty($v[$key])) {
                            $v[$key] = $v['config'] ?? [];
                        }
                        unset($v['config']);

                        return $v;
                    })
                ->end()
                ->cannotBeOverwritten()
                // _{TYPE}_config is renamed config
                ->validate()
                    ->ifTrue(fn ($v) => isset($v[$this->normalizedConfigTypeKey($v['type'])]))
                    ->then(function ($v) {
                        $key = $this->normalizedConfigTypeKey($v['type']);
                        $v['config'] = $v[$key];
                        unset($v[$key]);

                        return $v;
                    })
                ->end()

            ->end();

        $this->registerTypes($rootNode);

        return $treeBuilder;
    }

    private function addBeforeNormalization(ArrayNodeDefinition $node): void
    {
        $node
            // process beforeNormalization (should be execute after relay normalization)
            ->beforeNormalization()
                ->ifTrue(fn ($types) => is_array($types))
                ->then(fn ($types) => Config\Processor::process($types, Config\Processor::BEFORE_NORMALIZATION))
            ->end()
            ;
    }

    private function normalizedConfigTypeKey(string $type): string
    {
        return '_'.str_replace('-', '_', $type).'_config';
    }

    private function registerTypes(ArrayNodeDefinition $rootNode): void
    {
        // There is only one child
        $key = key($rootNode->getChildNodeDefinitions());

        $rootNode->getChildNodeDefinitions()[$key]
            ->children()
                ->scalarNode('class_name')
                    ->isRequired()
                    ->validate()
                    ->ifTrue(fn ($name) => !preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name))
                    ->thenInvalid('A valid class name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.')
                ->end()
            ->end()
            ->enumNode('type')->values($this->types)->isRequired()->end()
            ->arrayNode(InheritanceProcessor::INHERITS_KEY)
                ->prototype('scalar')->info('Types to inherit of.')->end()
            ->end()
            ->booleanNode('decorator')->info('Decorator will not be generated.')->defaultFalse()->end();

        foreach ($this->types as $type => $name) {
            $rootNode->append($type::create()->getDefinition());
        }

        $rootNode->variableNode('config')->end()
            ->end();
    }
}
