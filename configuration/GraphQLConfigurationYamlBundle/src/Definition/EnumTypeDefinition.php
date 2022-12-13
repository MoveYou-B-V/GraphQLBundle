<?php

declare(strict_types=1);

namespace Overblog\GraphQLConfigurationYamlBundle\Definition;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use function array_key_exists;
use function is_array;
use function is_null;

final class EnumTypeDefinition extends TypeDefinition
{
    public function getDefinition(): ArrayNodeDefinition
    {
        /** @var ArrayNodeDefinition $node */
        $node = self::createNode('_enum_config');

        /** @phpstan-ignore-next-line */
        $node
            ->children()
                ->append($this->nameSection())
                ->scalarNode('enumClass')
                    ->validate()
                        ->ifTrue(fn () => PHP_VERSION_ID < 80100)
                        ->thenInvalid('The enumClass option requires PHP 8.1 or higher.')
                    ->end()
                    ->validate()
                        ->ifTrue(fn ($v) => !class_exists($v))
                        ->thenInvalid('The specified enum Class "%s" does not exist.')
                    ->end()
                ->end()
                ->arrayNode('values')
                    ->useAttributeAsKey('name')
                    ->beforeNormalization()
                        ->ifTrue(fn ($v) => is_array($v))
                        ->then(function ($v) {
                            foreach ($v as $name => &$options) {
                                // short syntax NAME: VALUE
                                if (!is_null($options) && !is_array($options)) {
                                    $options = ['value' => $options];
                                }

                                // use name as value if no value given
                                if (!array_key_exists('value', $options)) {
                                    $options['value'] = $name;
                                }
                            }

                            return $v;
                        })
                    ->end()
                    ->prototype('array')
                        ->isRequired()
                        ->children()
                            ->scalarNode('value')->isRequired()->end()
                            ->append($this->descriptionSection())
                            ->append($this->deprecationReasonSection())
                            ->append($this->extensionsSection())
                        ->end()
                    ->end()
                ->end()
                ->append($this->descriptionSection())
                ->append($this->extensionsSection())
            ->end();

        return $node;
    }
}
