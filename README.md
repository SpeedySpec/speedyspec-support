# speedyspec-support
SpeedySpec Package Support - Common Classes used by SpeedySpec Packages

# Documentation

## Attributes

### InPackageVersion

Attribute for specifying when the code was added to the package.

```php

use SpeedySpec\Support\Attributes\InPackageVersion;

#[InPackageVersion('1.0.0')]
class MyClass
{
    #[InPackageVersion('1.0.0')]
    public function myMethod()
    {
    }
}
```

You may also specify multiple versions and the package name. This should be lowercase so that it is consistent with the
package name.

```php
#[InPackageVersion('1.0.0', 'speedyspec/speedyspec-support')]
class MyClass
{
    #[InPackageVersion('1.0.0', 'speedyspec/speedyspec-support')]
    #[InPackageVersion('2.0.0', 'speedyspec/speedyspec-support')]
    public function myMethod()
    {
    }
}
```
