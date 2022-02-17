<?php

namespace App\Controller;
/* c'est une importation  */
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        
        

/* c'est un formulaire de contact à remplir pour l'utilisateur  */
        $form= $this->createForm(ContactType::class);
        return $this->renderForm('contact/index.html.twig',[
            'controller_name' =>'ContactController',
            'formulaire' =>$form

        ]);
        $form->handleRequest($request);
        $data=$form->getData();
        
        
/* c'est un formulaire  avec un bouton "envoyer" avec une condition: si le formulaire est rempli correctement 
 et envoyé, c'est écrit succes
sinon le formulaire reste vide*/
        if($form->isSubmitted() && $form->isValid()){
            $email=$data["email"];
            $nom=$data["nom"];

            return $this->render('contact/success.html.twig',[
                'email'=>$email,
                'nom'=>$nom
            ]);

        }else{
            return $this->renderForm('contact/index.html.twig',[
                'controller_name' => 'ContactController',
                'formulaire'=>$form 
            ]);
        } 

        
       
    }
}
