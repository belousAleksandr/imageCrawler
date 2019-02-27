<?php

declare(strict_types=1);

namespace App\Util;

/**
 * Class ThumbnailWriter
 * Class purpose is resize and crop provided image
 *
 * @package App\Writer
 */
class ThumbnailMaker
{
    /**
     * @param \Imagick $imagick
     * @param int $imageSize
     */
    public function resizeImage(\Imagick $imagick, $imageSize = 200)
    {
        $width = $imagick->getImageWidth();

        $imagick->resizeImage($width, $imageSize, \Imagick::COLOR_BLACK, 1);
        $imagick->cropImage($imageSize, $imageSize, 0, 0);
    }
}