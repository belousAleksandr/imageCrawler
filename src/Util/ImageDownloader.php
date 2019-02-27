<?php

declare(strict_types=1);

namespace App\Util;


use App\Event\ImageUploadEvent;
use App\Model\ImageDownloadRequest;
use App\Model\ImageSettings;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ImageDownloader
{
    /** @var HttpClient */
    private $client;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * ImageDownloader constructor.
     * @param HttpClient $client
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(HttpClient $client, EventDispatcherInterface $eventDispatcher)
    {
        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ImageDownloadRequest $imageDownloadRequest
     * @param string $dir
     */
    public function download(ImageDownloadRequest $imageDownloadRequest, string $dir)
    {
        $response = $this->client->request($imageDownloadRequest->getUrl());
        $file = (string)$response->getBody();

        // In case if file has sizes less than required skip download for it
        if (!$this->isFileAvailableForDownload($file, $imageDownloadRequest->getImageSettings())){
            return;
        }
        $fileName = basename($imageDownloadRequest->getUrl());
        $imagick = new \Imagick();
        $imagick->readImageBlob($file, $dir.$fileName);

        $imageUploadEvent = new ImageUploadEvent($imagick);

        // Notify about upload an image
        $this->eventDispatcher->dispatch(ImageUploadEvent::PRE_SAVE, $imageUploadEvent);

        $imagick->writeImage();
    }

    private function isFileAvailableForDownload(string $file, ImageSettings $imageSettings): bool
    {
        $im = imagecreatefromstring($file);
        $width = imagesx($im);
        $height = imagesy($im);

        return ($width >= $imageSettings->getMinWidth() && $height >= $imageSettings->getMinHeight());
    }
}