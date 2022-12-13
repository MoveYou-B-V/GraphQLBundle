<?php

declare(strict_types=1);

namespace Overblog\GraphQLConfigurationMetadataBundle\Metadata;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * Annotation for GraphQL mutation.
 *
 * @Annotation
 * @NamedArgumentConstructor
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class Mutation extends Field
{
    /**
     * The target types to attach this mutation to (useful when multiple schemas are allowed).
     *
     * @var array<string>
     */
    public ?array $targetTypes;

    /**
     * {@inheritdoc}
     *
     * @param string|string[]|null $targetTypes
     */
    public function __construct(
        ?string $name = null,
        ?string $type = null,
        ?string $resolve = null,
        ?string $complexity = null,
        array|string|null $targetTypes = null
    ) {
        parent::__construct($name, $type, $resolve, $complexity);
        if ($targetTypes) {
            $this->targetTypes = is_string($targetTypes) ? [$targetTypes] : $targetTypes;
        }
    }
}
