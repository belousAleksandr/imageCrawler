<?php

declare(strict_types=1);

namespace App\Util;


/**
 * Class ImageTextCoordinatesCalculator
 * Calculate coordinates for put a text in middle of an image
 *
 * @package App\Writer
 */
class ImageTextCoordinatesCalculator
{
    /**
     * Calculate coordinates for provided text
     *
     * @param \Imagick $Imagick
     * @param \ImagickDraw $draw
     * @param string $text
     * @return array - [$x, $y]
     */
    public function calculate(\Imagick $Imagick, \ImagickDraw $draw, string $text): array
    {
        $width = $Imagick->getImageWidth();
        $height = $Imagick->getImageHeight();

        // Get text width and height
        $fontMetric = $Imagick->queryFontMetrics($draw, $text);
        $textWidth = $fontMetric['textWidth'];
        $textHeight = $fontMetric['textHeight'];

        // Calculate coordinates of the text
        $x = ($width / 2) - ($textWidth / 2);
        $y = ($height / 2) - ($textHeight / 2);

        return [$x, $y];
    }

}