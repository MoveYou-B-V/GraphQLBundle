<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationSdlBundle\ASTConverter;

class InputObjectNode extends ObjectNode
{
    protected const TYPENAME = 'input-object';
}
