<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class ParserSection
{
	public function __construct(
		private string $section,
		private string $value,
	) {
	}


	public function getSection(): string
	{
		return $this->section;
	}


	public function getValue(): string
	{
		return $this->value;
	}
}
