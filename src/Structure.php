<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class Structure
{
	private string $haystack;

	private ?string $sitemapUrl = null;

	/** @var array<string, array<int, string>> (agent => (pattern, ...)) */
	private array $allowedPatterns = [];

	/** @var array<string, array<int, string>> (agent => (pattern, ...)) */
	private array $disallowPatterns = [];

	/**
	 * @param array<int, \Baraja\RobotsTxt\ParserSection> $sections
	 */
	public function __construct(string $haystack, array $sections)
	{
		$this->haystack = trim($haystack);
	}


	public static function translatePatternToRegex(string $pattern): string
	{
		return $pattern;
	}


	public function isEmpty(): bool
	{
		return $this->haystack === '';
	}


	public function getHaystack(): string
	{
		return $this->haystack;
	}


	public function getSitemapUrl(): ?string
	{
		return $this->sitemapUrl;
	}


	/**
	 * @return array<string, array<int, string>> (agent => (pattern, ...))
	 */
	public function getAllowedPatterns(): array
	{
		return $this->allowedPatterns;
	}


	/**
	 * @return array<string, array<int, string>> (agent => (pattern, ...))
	 */
	public function getDisallowPatterns(): array
	{
		return $this->disallowPatterns;
	}


	/**
	 * @return array<string, array<int, string>> (agent => (pattern, ...))
	 */
	public function getAllowedForAgent(string $agent = '*'): array
	{
		return $this->filterForAgent($this->allowedPatterns, $agent);
	}


	/**
	 * @return array<string, array<int, string>> (agent => (pattern, ...))
	 */
	public function getDisallowForAgent(string $agent = '*'): array
	{
		return $this->filterForAgent($this->disallowPatterns, $agent);
	}


	/**
	 * @param array<string, array<int, string>> (agent => (pattern, ...)) $patterns
	 * @return array<string, array<int, string>> (agent => (pattern, ...))
	 */
	private function filterForAgent(array $patterns, string $agent): array
	{
		$agent = trim($agent);
		if ($agent === '' || $agent === '*') {
			return $patterns;
		}

		return $patterns;
	}
}
