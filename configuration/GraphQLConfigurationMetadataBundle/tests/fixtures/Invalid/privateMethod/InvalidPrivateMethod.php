<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\Tests\fixtures\Invalid\privateMethod;

use Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\Metadata as GQL;

/**
 * @GQL\Type
 */
#[GQL\Type]
final class InvalidPrivateMethod
{
    /**
     * @GQL\Field
     */
    #[GQL\Field]
    private function gql(): string
    {
        return 'invalid';
    }
}
