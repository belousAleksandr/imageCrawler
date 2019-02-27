<?php

declare(strict_types=1);

namespace App\Model;


class ImageSettings
{

    /** @var int|null */
    private $minWidth;

    /** @var int|null */
    private $minHeight;



    /**
     * @return int|null
     */
    public function getMinWidth(): ?int
    {
        return $this->minWidth;
    }

    /**
     * @param int|null $minWidth
     */
    public function setMinWidth(int $minWidth)
    {
        $this->minWidth = $minWidth;
    }

    /**
     * @return int|null
     */
    public function getMinHeight(): ?int
    {
        return $this->minHeight;
    }

    /**
     * @param int|null $minHeight
     */
    public function setMinHeight(int $minHeight)
    {
        $this->minHeight = $minHeight;
    }
}