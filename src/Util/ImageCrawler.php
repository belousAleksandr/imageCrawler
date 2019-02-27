<?php

declare(strict_types=1);

namespace App\Util;


use App\Model\CrawlerRequest;
use App\Model\ImageDownloadRequest;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\Finder;

class ImageCrawler
{
    /** @var HttpClient */
    private $client;

    /** @var ImageDownloader */
    private $imageDownloader;

    /** @var string */
    private $publicDir;

    /**
     * ImageCrawler constructor.
     *
     * @param HttpClient $client
     * @param ImageDownloader $imageDownloader
     * @param string $publicDir
     */
    public function __construct(HttpClient $client, ImageDownloader $imageDownloader, $publicDir = null)
    {
        $this->client = $client;
        $this->imageDownloader = $imageDownloader;
        $this->publicDir = $publicDir;

    }

    public function downloadImages(CrawlerRequest $crawlerRequest)
    {
        $url = $crawlerRequest->getUrl();
        $images = $this->getImagesFromUri($crawlerRequest->getUrl());

        foreach ($images as $image) {
            $imageUrl = $this->resolveUrlForImage($url, $image);
            $imageDownloadRequest = new ImageDownloadRequest($crawlerRequest->getImageSettings(), $imageUrl);
            $this->imageDownloader->download($imageDownloadRequest, $this->getImagesRootDir());
        }
    }

    /**
     * Return list of downloaded images
     *
     * @return array
     */
    public function downloadedImages(): array
    {
        $finder = new Finder();
        $finder->files()->in($this->getImagesRootDir());
        $images = [];
        foreach ($finder as $file) {
            $images[] = ['src' => $file->getPathname()];
        }

        return $images;
    }

    private function getImagesRootDir(): string
    {
        return $this->publicDir . 'images/';
    }

    /**
     * Resolve url for image
     *
     * @param string $url
     * @param string $path
     * @return string
     */
    private function resolveUrlForImage(string $url, string $path): string
    {
        $uri = parse_url($url, PHP_URL_HOST);
        $schema = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($path, PHP_URL_HOST);
        if ($host === null) {
            return $schema . '://' . $uri . $path;
        }

        return $path;
    }

    /**
     * Return list of available images form particular uri
     *
     * @param string $uri
     * @return array
     */
    private function getImagesFromUri(string $uri): array
    {
        $body = (string)$this->client->request($uri)->getBody();
        $crawler = new Crawler($body);

        return $crawler->filter('img')->extract(['src']);
    }
}