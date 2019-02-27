<?php

declare(strict_types=1);

namespace App\Model;


class ImageDownloadRequest
{
    /** @var ImageSettings */
    private $imageSettings;

    /** @var string */
    private $url;

    /**
     * ImageDownloadRequest constructor.
     *
     * @param ImageSettings $imageSettings
     * @param string $url
     */
    public function __construct(ImageSettings $imageSettings, string $url)
    {
        $this->imageSettings = $imageSettings;
        $this->url = $url;
    }

    /**
     * @return ImageSettings
     */
    public function getImageSettings(): ImageSettings
    {
        return $this->imageSettings;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}