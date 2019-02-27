<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class ImageUploadEvent extends Event
{
    const PRE_SAVE = 'pre.image.save';

    /** @var \Imagick */
    private $imagick;

    /**
     * ImageUploadEvent constructor.
     * @param \Imagick $imagick
     */
    public function __construct(\Imagick $imagick)
    {
        $this->imagick = $imagick;
    }

    /**
     * @return \Imagick
     */
    public function getImagick(): \Imagick
    {
        return $this->imagick;
    }
}