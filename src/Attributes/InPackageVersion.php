<?php

declare(strict_types=1);

namespace SpeedySpec\Support\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_ALL | Attribute::IS_REPEATABLE)]
class InPackageVersion {
	public function __construct(
		public string $version,
		public string|null $package = null,
	) {}
}
