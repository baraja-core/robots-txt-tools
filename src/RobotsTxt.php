<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class RobotsTxt
{
	public function render(Structure $structure): string
	{
		return (new Renderer)->render($structure);
	}


	public function parse(string $haystack): Structure
	{
		return (new Parser)->parse($haystack);
	}


	public function getValidator(Structure $structure): Validator
	{
		return new Validator($structure);
	}


	public function fetch(string $url): string
	{
		return (new RobotsBot)->fetch($url);
	}
}
