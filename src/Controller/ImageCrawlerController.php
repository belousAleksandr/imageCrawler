<?php

namespace App\Controller;

use App\Form\CrawlerRequestType;
use App\Util\ImageCrawler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageCrawlerController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(CrawlerRequestType::class);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageCrawler = $this->get('app.util.image_crawler');
            $imageCrawler->downloadImages($form->getData());
        }

        return $this->render('image_crawler/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
