<?php

namespace App\Service;

use \Stripe\StripeClient;

class PaiementService
{

    private $cartService;
    private $stripe;

    public function __construct(CartService $cartService)
    {
       $this->cartService =$cartService;
       $this->stripe = new StripeClient('sk_test_51KRHXgJh9aVwNMU0HZQ6yDz7Xm6GUJtbTgXUhfVAXRgW6B58t51aQ3yw88uY5ZnUAT0PJVo7O3Q09wo8tXJvtgrR00N0ghs6Lv');
    }

    public function create():string
    {
        $cart =$this->cartService->get();
        $items =[];
        foreach($cart['elements'] as $produitId =>$element)
        {
            $items[] =[
                'amount'=> $element['produit']->getPrice()* 100,
                'quantity'=>$element['quantity'],
                'currency'=>'eur',
                'name'=>$element['produit']->getTitle()

            ];
        }
    }

} 

