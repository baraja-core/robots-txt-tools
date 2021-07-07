<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


final class Parser
{
	public function parse(string $haystack): Structure
	{
		$analyzedData = $this->analyze($haystack);

		return new Structure($haystack, $analyzedData['sections']);
	}


	/**
	 * @phpstan-return array{sections: array<int, ParserSection>, ignoredLines: array<int, string>}
	 */
	private function analyze(string $haystack): array
	{
		$fileSize = mb_strlen($haystack);
		if ($fileSize > 500_000) {
			throw new ParserException(
				'Robots Parser: Robots content is too big. '
				. 'Maximal allowed size is 500 KiB, but ' . $fileSize . ' KiB given.',
				$haystack,
			);
		}

		$s = trim($haystack);

		// Normalize new lines
		$s = str_replace(["\r\n", "\r"], "\n", $s);

		// remove control characters; leave \t + \n
		$s = (string) preg_replace('#[\x00-\x08\x0B-\x1F\x7F-\x9F]+#u', '', $s);

		$return = [];
		$ignoredLines = [];
		foreach (explode("\n", $s) as $lineNumber => $line) {
			// general format <field>:<value><#optional-comment>
			if (preg_match('/^([^:\n#]+):([^\n#]+)/', $line, $parser)) {
				$section = trim($parser[1]);
				$value = trim($parser[2]);
				if ($section === '') { // ignore empty sections
					continue;
				}
				if ($value === '') {
					throw new ParserException(
						'Robots Parser: Value for section "' . $section . '" can not be empty.'
						. '[on line ' . ($lineNumber + 1) . ']',
						$haystack,
						$lineNumber + 1,
					);
				}

				$return[] = new ParserSection($section, $value);
			} elseif (trim($line) !== '') {
				$ignoredLines[] = $line;
			}
		}

		return [
			'sections' => $return,
			'ignoredLines' => $ignoredLines,
		];
	}
}
