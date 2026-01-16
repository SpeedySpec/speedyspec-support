<?php

declare(strict_types=1);

use SpeedySpec\Support\Attributes\InPackageVersion;

covers(InPackageVersion::class);

test('creates attribute with version only', function () {
    $attribute = new InPackageVersion('1.0.0');

    expect($attribute->version)->toBe('1.0.0')
        ->and($attribute->package)->toBeNull();
});

test('creates attribute with version and package', function () {
    $attribute = new InPackageVersion('2.1.0', 'speedyspec/support');

    expect($attribute->version)->toBe('2.1.0')
        ->and($attribute->package)->toBe('speedyspec/support');
});

test('accepts semver versions', function () {
    $versions = ['1.0.0', '0.1.0', '10.20.30', '1.0.0-alpha', '1.0.0-beta.1', '2.0.0-rc.1'];

    foreach ($versions as $version) {
        $attribute = new InPackageVersion($version);
        expect($attribute->version)->toBe($version);
    }
});

test('can be applied to class', function () {
    $reflection = new ReflectionClass(ClassWithVersionAttribute::class);
    $attributes = $reflection->getAttributes(InPackageVersion::class);

    expect($attributes)->toHaveCount(1);

    $instance = $attributes[0]->newInstance();
    expect($instance->version)->toBe('1.0.0')
        ->and($instance->package)->toBe('test/package');
});

test('can be applied to method', function () {
    $reflection = new ReflectionMethod(ClassWithVersionAttribute::class, 'versionedMethod');
    $attributes = $reflection->getAttributes(InPackageVersion::class);

    expect($attributes)->toHaveCount(1);

    $instance = $attributes[0]->newInstance();
    expect($instance->version)->toBe('1.1.0')
        ->and($instance->package)->toBeNull();
});

test('can be applied to property', function () {
    $reflection = new ReflectionProperty(ClassWithVersionAttribute::class, 'versionedProperty');
    $attributes = $reflection->getAttributes(InPackageVersion::class);

    expect($attributes)->toHaveCount(1);

    $instance = $attributes[0]->newInstance();
    expect($instance->version)->toBe('1.2.0');
});

test('can be applied to constant', function () {
    $reflection = new ReflectionClassConstant(ClassWithVersionAttribute::class, 'VERSIONED_CONSTANT');
    $attributes = $reflection->getAttributes(InPackageVersion::class);

    expect($attributes)->toHaveCount(1);

    $instance = $attributes[0]->newInstance();
    expect($instance->version)->toBe('1.3.0');
});

test('can be applied to parameter', function () {
    $reflection = new ReflectionParameter([ClassWithVersionAttribute::class, 'methodWithVersionedParam'], 'param');
    $attributes = $reflection->getAttributes(InPackageVersion::class);

    expect($attributes)->toHaveCount(1);

    $instance = $attributes[0]->newInstance();
    expect($instance->version)->toBe('1.4.0');
});

test('properties are publicly accessible', function () {
    $attribute = new InPackageVersion('1.0.0', 'my/package');

    expect($attribute)->toHaveProperty('version')
        ->and($attribute)->toHaveProperty('package');
});

test('has target all attribute', function () {
    $reflection = new ReflectionClass(InPackageVersion::class);
    $attributes = $reflection->getAttributes(\Attribute::class);

    expect($attributes)->toHaveCount(1);

    $attrInstance = $attributes[0]->newInstance();
    expect($attrInstance->flags)->toBe(\Attribute::TARGET_ALL);
});

// Test fixtures
#[InPackageVersion('1.0.0', 'test/package')]
class ClassWithVersionAttribute
{
    #[InPackageVersion('1.3.0')]
    public const VERSIONED_CONSTANT = 'value';

    #[InPackageVersion('1.2.0')]
    public string $versionedProperty = '';

    #[InPackageVersion('1.1.0')]
    public function versionedMethod(): void
    {
    }

    public function methodWithVersionedParam(
        #[InPackageVersion('1.4.0')]
        string $param
    ): void {
    }
}
