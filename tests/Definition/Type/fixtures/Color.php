<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Tests\Definition\Type\fixtures;

use Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\Metadata as GQL;

/**
 * @GQL\Enum
 * @GQL\EnumValue(name="RED", description="The color red")
 */
#[GQL\Enum]
enum Color
{
    #[GQL\Description('The color red')]
    case RED;

    case GREEN;

    case BLUE;

    case YELLOW;
}
