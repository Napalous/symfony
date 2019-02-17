<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="facture")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Facture::class);
        $cmpt=$repo->findAll();
        return $this->render('facture/index.html.twig', [
            'selectfa' => $cmpt
        ]);
    }
    /**
     * @Route("/facture/new", name="form_facture")
     */
    public function creationfa(Request $request,ObjectManager $manager)
    {
        $facture=new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {            
            $manager->persist($facture);
            $manager->flush();
            return $this->redirectToRoute('facture');
        }
        return $this->render('facture/creationfa.html.twig', ['formFact' => $form->createView()]);
    }

    /**
     * @Route("/facture/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $cmpt = $this->getDoctrine()->getRepository(Facture::class)->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($cmpt);
        $manager->flush();

        $reponse = new Response();
        $reponse->send();   
    }


    /**
     * @Route("/facture/edit/{id}", name="editfact")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $facture=new Facture();        
        $facture = $this->getDoctrine()->getRepository(Facture::class)->find($id);
        $form = $this->createForm(FactureType::class,$facture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $facture=$form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('facture');
        }
        return $this->render('facture/edit.html.twig', ['modFact' => $form->createView()]);
  
    }


         /**
     * @Route("/formatfact", name="form_factjson")
     */
    public function jsonCompte(FactureRepository $repo)
    {
        $compteurs = $repo->findAll();
        $tab = [];
        $_tab = [];
        $compteur = [];
        foreach($compteurs as $tab)
        {

            $_tab['id'] = $tab->getId();
            $_tab['mois'] = $tab->getMois();
            $_tab['consommation'] = $tab->getConsommation();
            $_tab['prix'] = $tab->getPrix();
            $_tab['reglement'] = $tab->getReglement();  
            $_tab['abonnement'] = $tab->getAbonnement();      
            $compteur[] = $_tab;
        }
        return new JsonResponse($compteur);

    }
}
