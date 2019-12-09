<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin", name="admin_")
 */
class DashbordController extends AbstractController
{
    /**
     * @Route("/", name="dashbord")
     */
    public function index()
    {
        return $this->render('admin/dashbord/index.html.twig');
    }
}
