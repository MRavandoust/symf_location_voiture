<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/vehicule')]
class AdminVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('admin_vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $vehicule->setEnregisterAt(new \DateTimeImmutable('now'));

            // Upload image
            $imageFile = $form->get('image')->getData();
            if($imageFile){
                
                // 1 - Création d'un nom unique pour image
                $nomImage = date("YmdHis"). "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();  

                // 2 - Déplacer le fichier image dans le dossier public
                $imageFile->move(
                    $this->getParameter('imageVehicule'),
                    $nomImage
                );

                // 3 - Enregistrer dans l'objet $produit à la propriété image du fichier
                $vehicule->setImage($nomImage);
            }



            $vehiculeRepository->add($vehicule, true);

            return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('admin_vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->add($vehicule, true);

            return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $vehiculeRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }


}
