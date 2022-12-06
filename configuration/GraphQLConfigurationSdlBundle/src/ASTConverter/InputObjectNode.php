<?php

declare(strict_types=1);

namespace Overblog\GraphQL\Bundle\ConfigurationSdlBundle\ASTConverter;

final class InputObjectNode extends ObjectNode
{
    protected const TYPENAME = 'input-object';
}
