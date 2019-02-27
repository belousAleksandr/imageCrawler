<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Form\CrawlerRequestType;
use App\Util\ImageCrawler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api")
 * Class ImageUploaderController
 * @package App\Controller\Rest
 */
class ImageUploaderController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/upload-images", name="api_upload_images")
     * @param Request $request
     * @return View
     */
    public function uploadImagesAction(Request $request): View
    {
        $form = $this->createForm(CrawlerRequestType::class);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCrawler = $this->get('app.util.image_crawler');
            $imageCrawler->downloadImages($form->getData());

            return $this->view(['success' => true]);
        }

        return $this->view(['success' => false, 'errorsData' => $form->getErrors(true)]);
    }

    /**
     * @Rest\Get("/uploaded-images", name="api_uploaded_images")
     * @return View
     */
    public function uploadedImagesAction(): View
    {
        $imageCrawler = $this->get('app.util.image_crawler');

        return $this->view($imageCrawler->downloadedImages());
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getSubscribedServices()
    {
        $subscribedServices = parent::getSubscribedServices();
        $subscribedServices['app.util.image_crawler'] = ImageCrawler::class;

        return $subscribedServices;
    }
}