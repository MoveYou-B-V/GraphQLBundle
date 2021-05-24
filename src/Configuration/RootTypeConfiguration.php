<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Configuration;

use Overblog\GraphQLBundle\Configuration\Traits\ClassNameTrait;
use Overblog\GraphQLBundle\Configuration\Traits\PublicNameTrait;

abstract class RootTypeConfiguration extends TypeConfiguration
{
    use PublicNameTrait;
    use ClassNameTrait;
}
