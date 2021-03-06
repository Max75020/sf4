<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile_")
 * @IsGranted("ROLE_USER")
 */
class UserProfileController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        // Récupération de l'utilisateur courant
        $user = $this->getUser();
        // Passage de l'utilisateur au formulaire pour pré-remplir les champs
        $profileForm = $this->createForm(UserProfileFormType::class, $user);
        $profileForm->handleRequest($request);

        // Vérification de validité
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            // Formulaire lié à une classe entité: getData() retourne l'entité
            $user = $profileForm->getData();

            // Mise à jour de l'entité en BDD
            $em->persist($user);
            $em->flush();

            //Ajout d'un message flash
            $this->addFlash('success', 'Votre profil a été mis à jour.');
        }

        return $this->render('user/profile.html.twig', [
            'profile_form' => $profileForm->createView()
        ]);
    }
}

/**
 *  User (0,n) -- Note (1,1) -- Record
 */