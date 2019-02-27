<?php

declare(strict_types=1);

namespace App\Model;


class CrawlerRequest
{
    /** @var string|null */
    private $url;

    /** @var ImageSettings|null */
    private $imageSettings;


    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return ImageSettings|null
     */
    public function getImageSettings(): ?ImageSettings
    {
        return $this->imageSettings;
    }

    /**
     * @param ImageSettings|null $imageSettings
     */
    public function setImageSettings(ImageSettings $imageSettings)
    {
        $this->imageSettings = $imageSettings;
    }

}