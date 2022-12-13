<?php

declare(strict_types=1);

namespace Overblog\GraphQLConfigurationMetadataBundle\Tests\fixtures\Enum;

use Overblog\GraphQLConfigurationMetadataBundle\Metadata as GQL;
use Overblog\GraphQLConfigurationMetadataBundle\Tests\Constants;

/**
 * @GQL\Enum
 * @GQL\EnumValue(name="CHISS", description="The Chiss race")
 * @GQL\EnumValue(name="ZABRAK", deprecationReason="The Zabraks have been wiped out")
 * @GQL\Description("The list of races!")
 */
#[GQL\Enum]
#[GQL\Description('The list of races!')]
final class Race
{
    public const HUMAIN = 1;

    #[GQL\Description('The Chiss race')]
    public const CHISS = '2';

    #[GQL\Deprecated('The Zabraks have been wiped out')]
    public const ZABRAK = '3';
    public const TWILEK = Constants::TWILEK;

    /**
     * @var int|string
     */
    public $value;

    /**
     * @param int|string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
