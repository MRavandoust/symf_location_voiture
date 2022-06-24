<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'app_vehicule')]
    public function index(VehiculeRepository $vehicule): Response
    {
        $voitures = $vehicule->findAll();

        return $this->render('vehicule/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }



    #[Route('/fiche-voiture/{id}', name: 'fiche_voiture')]
    public function voir(Vehicule $voiture): Response
    {
        return $this->render('vehicule/fiche_voiture.html.twig', [
            'voiture' => $voiture
        ]);
    }






}
