<?php

declare(strict_types=1);

namespace App\Writer;

use App\Util\ImageTextCoordinatesCalculator;

/**
 * Class ImageTextWriter
 * Class purpose is adding a text to provided image
 *
 * @package App\Writer
 */
class ImageTextWriter
{
    /** @var ImageTextCoordinatesCalculator */
    private $imageTextCoordinatesCalculator;

    /**
     * ImageTextWriter constructor.
     *
     * @param ImageTextCoordinatesCalculator $imageTextCoordinatesCalculator
     */
    public function __construct(ImageTextCoordinatesCalculator $imageTextCoordinatesCalculator)
    {
        $this->imageTextCoordinatesCalculator = $imageTextCoordinatesCalculator;
    }

    /**
     * Write a text at particular image
     *
     * @param \Imagick $imagick
     * @param $text
     * @param int $fontSize
     * @param string $font
     * @param string $color
     */
    public function write(\Imagick $imagick, $text, int $fontSize = 14, $font = 'times', $color = '#000000')
    {
        $draw = $this->createDraw($fontSize, $font, $color);

        list($x, $y) = $this->imageTextCoordinatesCalculator->calculate($imagick, $draw, $text);

        $imagick->annotateImage(
            $draw,
            $x,
            $y,
            0,
            $text
        );

        $imagick->writeImage();
    }

    /**
     * Create ImagickDraw with some presets
     *
     * @param int $fontSize
     * @param string $font
     * @param string $color
     * @return \ImagickDraw
     */
    private function createDraw(int $fontSize, $font = 'times', $color = '#000000'): \ImagickDraw
    {
        $imagickDraw = new \ImagickDraw();
        $imagickDraw->setFont($font);
        $imagickDraw->setFontSize($fontSize);
        $imagickDraw->setFillColor(new \ImagickPixel($color));
        $imagickDraw->setStrokeAntialias(true);
        $imagickDraw->setTextAntialias(true);

        return $imagickDraw;
    }
}