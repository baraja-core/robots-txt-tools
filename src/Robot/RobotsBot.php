<?php

declare(strict_types=1);

namespace Baraja\RobotsTxt;


use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\Caching\Storages\MemoryStorage;
use Nette\Http\Url;

final class RobotsBot
{
	private Cache $cache;


	public function __construct(
		?Storage $storage = null,
		private string $cacheExpiration = '24 hours',
	) {
		$this->cache = new Cache($storage ?? new MemoryStorage, 'baraja-robots.txt-fetcher');
	}


	public function fetch(string $url): string
	{
		$domain = (new Url($url))->getDomain(3);
		$fileUrl = $domain . '/robots.txt';

		$cache = $this->cache->load($fileUrl);
		if ($cache === null) {
			try {
				$content = $this->download($fileUrl);
			} catch (\Throwable $e) {
				$cacheBackup = $this->cache->load($fileUrl . '-backup');
				if ($cacheBackup !== null) {
					return (string) $cacheBackup;
				}
				throw $e;
			}
			$this->saveToCache($fileUrl, $content);
			$this->saveToCache($fileUrl . '-backup', $content, true);
			$cache = $content;
		}

		return (string) $cache;
	}


	private function download(string $url): string
	{
		return (string) @file_get_contents(
			$url,
			false,
			stream_context_create(
				[
					'http' => [
						'method' => 'GET',
						'user_agent' => 'BarajaBot in PHP',
					],
				],
			),
		);
	}


	private function saveToCache(string $key, string $content, bool $backup = false): void
	{
		$this->cache->save(
			key: $key,
			data: $content,
			dependencies: [
				Cache::EXPIRATION => $backup === true
					? '1 month'
					: $this->cacheExpiration,
			],
		);
	}
}
