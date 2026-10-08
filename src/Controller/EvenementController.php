<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]         // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function index(EvenementRepository $evenementRepository): Response
    {        
        $evenements = $evenementRepository->findAll();
        // dd($evenements);     debug pour voir si il y a des element dans la BDD
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            ]);
    }
            
    #[Route('/evenement_show/{id}', name: 'evenement_show')]         // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function show(evenement $evenement, EvenementRepository $evenementRepository): Response
    {
    
        $user = $evenement->getFkUser();
        $nomUser = $user->getNom();
        return $this->render('evenement/evenement_show.html.twig', [
            'evenement' => $evenement,
            'nomUser' => $nomUser,
        ]);
    }

    #[Route('/addEvenement', name: 'evenement_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Evenement = new Evenement();

        $form = $this->createForm(EvenementType::class, $Evenement);

        // Vérifie si le formulaire est envoyé ou non
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupère les données du formulaire
            $Evenement = $form->getData();
            $Evenement->setFkUser($this->getuser());
            $entityManager->persist($Evenement); // on ajoute l'Evenement dans l'entity manager pour qu'il puisse s'en occuper au moment du flush
            $entityManager->flush(); // on execute les req en BDD
            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('evenement/add.html.twig', [
            'form' => $form,
        ]);
    }
}
