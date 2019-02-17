<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compteur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\CompteurType;
use App\Repository\CompteurRepository;

class CompteurController extends AbstractController
{
    /**
     * @Route("/compteur", name="compteur")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Compteur::class);
        $cmpt=$repo->findAll();
        return $this->render('compteur/index.html.twig', [
            'selectcmpt' => $cmpt
        ]);
    }
    /**
     * @Route("/compteur/new", name="form_creation")
     */
    public function creation(Request $request,ObjectManager $manager)
    {
        $compteur = new Compteur();
        $form = $this->createForm(CompteurType::class, $compteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($compteur);
            $manager->flush();
            return $this->redirectToRoute('compteur');
        }
                     
        return $this->render('compteur/creation.html.twig', ['formCompteur' => $form->createView()]);
    }
    /**
     * @Route("/compteur/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $cmpt = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($cmpt);
        $manager->flush();

        $reponse = new Response();
        $reponse->send();   
    }

      /**
     * @Route("/compteur/edit/{id}", name="editcompte")
     * @Method({"GET","POST"})
     */
    public function edit(Request $request, $id)
    {
        $comp=new Compteur();        
        $comp = $this->getDoctrine()->getRepository(Compteur::class)->find($id);
        $form = $this->createForm(CompteurType::class,$comp);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comp=$form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('compteur');
        }
        return $this->render('compteur/edit.html.twig', ['modcomp' => $form->createView()]);
  
    }
    /**
     * @Route("/formatcompte", name="form_cmptjson")
     */
    public function jsonCompte(CompteurRepository $repo)
    {
        $compteurs = $repo->findAll();
        $tab = [];
        $_tab = [];
        $compteur = [];
        foreach($compteurs as $tab)
        {
            $_tab['id'] = $tab->getId();
            $_tab['numero'] = $tab->getNumero();
            $compteur[] = $_tab;
        }
        return new JsonResponse($compteur);

    }

}
