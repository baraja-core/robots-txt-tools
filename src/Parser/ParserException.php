<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class ParserException extends \InvalidArgumentException
{
	public function __construct(
		string $message,
		private string $content,
		private int $contentLine = 1,
		?\Throwable $previous = null,
	) {
		if ($this->contentLine < 1) {
			$this->contentLine = 1;
		}
		parent::__construct($message, 500, $previous);
	}


	public function getContent(): string
	{
		return $this->content;
	}


	public function getContentLine(): int
	{
		return $this->contentLine;
	}
}
