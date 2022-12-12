<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Tests\Resolver;

use GraphQL\Type\Definition\ObjectType;
use Overblog\GraphQLBundle\Resolver\GeneratedTypeSolutionProvider;
use Overblog\GraphQLBundle\Resolver\TypeResolver;
use Overblog\GraphQLBundle\Resolver\UnresolvableException;

final class TypeResolverTest extends AbstractResolverTest
{
    protected function createResolver(): TypeResolver
    {
        // NOTE: mocking of final class permitted by the package "dg/bypass-finals"
        $provider = $this->createMock(GeneratedTypeSolutionProvider::class);
        $provider->method('hasSolution')->willReturn(false);

        return new TypeResolver($provider);
    }

    protected function getResolverSolutionsMapping(): array
    {
        return [
            'Toto' => ['factory' => fn () => new ObjectType(['name' => 'Toto', 'fields' => []]), 'aliases' => ['foo']],
            'Tata' => ['factory' => fn () => new ObjectType(['name' => 'Tata', 'fields' => []]), 'aliases' => ['bar']],
        ];
    }

    public function testResolveKnownType(): void
    {
        $type = $this->resolver->resolve('Toto');

        $this->assertInstanceOf(ObjectType::class, $type);
        $this->assertSame('Toto', $type->name);
    }

    public function testResolveUnknownType(): void
    {
        $this->expectException(UnresolvableException::class);
        $this->resolver->resolve('Fake');
    }

    public function testAliases(): void
    {
        $this->assertSame(
            $this->resolver->resolve('Tata'),
            $this->resolver->resolve('bar')
        );
        $this->assertSame(
            $this->resolver->getSolution('Tata'),
            $this->resolver->getSolution('bar')
        );
        $this->assertSame(
            $this->resolver->resolve('Toto'),
            $this->resolver->resolve('foo')
        );
        $this->assertSame(
            $this->resolver->getSolution('Toto'),
            $this->resolver->getSolution('foo')
        );
    }
}
