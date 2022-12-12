<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Tests\Configuration;

use Overblog\GraphQLBundle\Configuration\ArgumentConfiguration;
use Overblog\GraphQLBundle\Configuration\Configuration;
use Overblog\GraphQLBundle\Configuration\EnumConfiguration;
use Overblog\GraphQLBundle\Configuration\EnumValueConfiguration;
use Overblog\GraphQLBundle\Configuration\FieldConfiguration;
use Overblog\GraphQLBundle\Configuration\ObjectConfiguration;

class ConfigurationTest extends BaseConfigurationTest
{
    public function testMerging(): void
    {
        $configuration1 = (new Configuration())
            ->addType(self::object('Type1', ['f' => 'String']))
            ->addType(self::object('Type2', ['f' => 'String']));

        $configuration2 = (new Configuration())
            ->addType(self::object('Type3', ['f' => 'String']))
            ->addType(self::object('Type4', ['f' => 'String']));

        $configuration1->merge($configuration2);

        $this->assertCount(4, $configuration1->getTypes());
    }

    public function testRetrieveTypeByPath(): void
    {
        $configuration = new Configuration();
        $configuration
            ->addType(ObjectConfiguration::create('type1')
                ->addField(FieldConfiguration::create('field1', 'String')
                        ->addArgument(ArgumentConfiguration::create('arg1', 'Int'))
                    )
                );
        $configuration
            ->addType(EnumConfiguration::create('enum1')->addValue(EnumValueConfiguration::create('value1', 2)));

        $this->assertEquals($configuration->get('type1.field1.arg1')->getType(), 'Int');
        $this->assertEquals($configuration->get('enum1.value1')->getValue(), 2);
    }
}
