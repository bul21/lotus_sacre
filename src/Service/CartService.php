<?php


namespace App\Service;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class CartService 
{
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface =$sessionInterface;
    }

    public function get()
    {
        return $this->sessionInterface->get('cart',[
            'elements'=>[],
            'total'=>0.0

        ]);
        
    }
     
    public function add(Produit $produit) 
    {
        $cart =$this->get();
        $produitId = $produit->getId();

        if(!isset($cart['elements'][$produitId]))
        {
            $cart['elements'][$produitId] = [
                'produit' =>$produit,
                'quantity' => 0
            ];
        }

        $cart['total'] =$cart['total']+ $produit->getPrice();
        $cart['elements'][$produitId]['quantity'] =$cart['elements'][$produitId]['quantity'] +1;

        $this ->sessionInterface->set('cart',$cart);

    }
    public function remove(Produit $produit)
    {

        $cart =$this->get();
        $produitId = $produit->getId();

        if (!isset($cart['elements'][$produitId]))
        {
            return; 
        }

        $cart['total'] =$cart['total']+ $produit->getPrice();
        $cart['elements'][$produitId]['quantity'] =$cart['elements'][$produitId]['quantity'] -1;

        if ($cart['elements'][$produitId]['quantity']<=0)
        {
            unset($cart['elements'][$produitId]);

        }
        $this ->sessionInterface->set('cart',$cart);

    }
    public function clear()
    {
        $this->sessionInterface->remove('cart');
    }
}