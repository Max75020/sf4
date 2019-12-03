<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/record", name="record_")
 */

class RecordController extends AbstractController
{
    /**
     * @Route("/{id}", name="page")
     */
    public function index($id)
    {
        return $this->render('ranking/news.html.twig');
    }
}
