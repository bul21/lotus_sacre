<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/produit")
 */
class AdminProduitController extends AbstractController
{
    /**
     * @Route("/", name="admin_produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManagerInterface): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $produit->setImageFilename($imageFileName);
            }
            
            $entityManagerInterface->persist($produit);
            $entityManagerInterface->flush();
            
        

            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->renderForm('admin_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}", name="admin_produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('admin_produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FileUploader $fileUploader,Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $produit->setImageFilename($imageFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->render('admin_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
