<?php

namespace App\EventSubscriber;

use App\Event\ImageUploadEvent;
use App\Util\ThumbnailMaker;
use App\Writer\ImageTextWriter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageUploadSubscriber implements EventSubscriberInterface
{
    /** @var ThumbnailMaker */
    private $thumbnailWriter;

    /** @var ImageTextWriter */
    private $imageTextWriter;

    /**
     * ImageUploadSubscriber constructor.
     * @param ThumbnailMaker $thumbnailWriter
     * @param ImageTextWriter $imageTextWriter
     */
    public function __construct(ThumbnailMaker $thumbnailWriter, ImageTextWriter $imageTextWriter)
    {
        $this->thumbnailWriter = $thumbnailWriter;
        $this->imageTextWriter = $imageTextWriter;
    }

    /**
     * Adds extra image modifying
     *
     * @param ImageUploadEvent $event
     */
    public function onPreImageSave(ImageUploadEvent $event)
    {
        $imagick = $event->getImagick();

        // Resize image by requirements
        $this->thumbnailWriter->resizeImage($imagick);

        // TODO: It's tmp solution
        $message = 'a test message';
        $this->imageTextWriter->write($imagick, $message);

    }

    public static function getSubscribedEvents()
    {
        return [
           ImageUploadEvent::PRE_SAVE => 'onPreImageSave',
        ];
    }
}
