<?php

namespace App\Controller;


use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em)
    {
        //Création d'une nouvelle instance d'artiste
        $artist = new Artist();
        $artist
            ->setName("Maxime")
            ->setDescription("Real Tall, stay mother fucking real")
            ;

        //INSERT / UPDATE insérer ou modifié
        $em->persist($artist);

        //DELETE
        // $em->remove($entite);

        // Execution des requetes SQL
        $em->flush();

        return $this->render('index.html.twig');
    }
}