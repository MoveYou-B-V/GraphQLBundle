<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\Tests\fixtures\Invalid\doctrineRelationGuessing;

use Doctrine\ORM\Mapping as ORM;
use Overblog\GraphQL\Bundle\ConfigurationMetadataBundle\Metadata as GQL;

/**
 * @GQL\Type
 */
#[GQL\Type]
final class InvalidDoctrineRelationGuessing
{
    /**
     * @ORM\OneToOne(targetEntity="MissingType")
     * @GQL\Field
     */
    #[GQL\Field]
    public object $myRelation;
}
