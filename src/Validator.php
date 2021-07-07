<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class Validator
{
	public function __construct(
		private Structure $structure,
	) {
	}


	public function isSitemap(): bool
	{
		return $this->structure->getSitemapUrl() !== null;
	}


	public function isAllow(string $url, string $userAgent = '*'): bool
	{
		if ($this->structure->isEmpty() === true) {
			return true;
		}

		return false;
	}


	public function isDisallow(string $url, string $userAgent = '*'): bool
	{
		return $this->isAllow($url, $userAgent) === false;
	}
}
