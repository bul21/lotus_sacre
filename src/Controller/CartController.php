<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {
        $cart =$cartService->get();
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' =>$cart
        ]);
    }


/**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(CartService $cartService, Produit $produit): Response
    {
        $cartService->add($produit);
        return $this->redirectToRoute('cart_index');
    }

    
    /**
    * @Route("/cart/remove/{id}", name="cart_remove")
    */
    public function remove(CartService $cartService, Produit $produit): Response
   {
       $cartService->remove($produit);
       return $this->redirectToRoute('cart_index');
   
   }


/**
    * @Route("/cart/clear", name="cart_clear")
    */
    public function clear(CartService $cartService): Response
    {
       $cartService->clear();
       return $this->redirectToRoute('cart_index');
   
    }
}