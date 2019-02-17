<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use App\Repository\CompteurRepository;
use App\Entity\Compteur;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/abonnement", name="abonnement")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Abonnement::class);
        $cmpt=$repo->findAll();
        return $this->render('abonnement/index.html.twig', [
            'selectab' => $cmpt
        ]);
    }
    /**
     * @Route("/abonnement/new", name="form_abonnement")
     */

    public function createab(Abonnement $abon=null,Request $request,ObjectManager $manager,CompteurRepository $repo)
    {
        $em = $this->getDoctrine()->getManager();
        $sql="SELECT compteur.id FROM `compteur` LEFT JOIN `abonnement` ON compteur.id=abonnement.compteur_id WHERE compteur_id IS NULL";
        $result = $em->getConnection()->prepare($sql);
        $result->execute();
        $i=0;
        while($ligne = $result->fetch())
        {
            $val = $ligne['id'];
            $cpt[$i] = $repo->find($ligne['id']);
            $i++;
        }
        if(!$abon)
        {
            $abon = new Abonnement();
        }
        $form = $this->createFormBuilder($abon)
                     ->add('contrat')                     
                     ->add('compteur',EntityType::class,[
                         'class' => Compteur::class,
                         'choices' =>$cpt,
                         'expanded' =>false,
                         'multiple' => false
                     ])
                     ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $abon->setDateAb(new \DateTime());
            $abon->setCumulAnc(0);
            $abon->setCumulNouv(0);
            $manager->persist($abon);
            $manager->flush();
            
        }
        return $this->render('abonnement/creationab.html.twig', ['formAbon' => $form->createView()]);
    }
    /**
     * @Route("/abonnement/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $cmpt = $this->getDoctrine()->getRepository(Abonnement::class)->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($cmpt);
        $manager->flush();

        $reponse = new Response();
        $reponse->send();   
    }

      /**
     * @Route("/abonnement/edit/{id}", name="editabon")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $abon=new Abonnement();        
        $abon = $this->getDoctrine()->getRepository(Abonnement::class)->find($id);
        $form = $this->createForm(AbonnementType::class,$abon);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $abon->setCumulAnc($abon->getCumulNouv()+$abon->getCumulAnc());                
            $abon=$form->getData();                        
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('abonnement');
        }
        return $this->render('abonnement/edit.html.twig', ['modabon' => $form->createView()]);
  
    }

     /**
     * @Route("/formatabon", name="form_abonjson")
     */
    public function jsonCompte(AbonnementRepository $repo)
    {
        $compteurs = $repo->findAll();
        $tab = [];
        $_tab = [];
        $compteur = [];
        foreach($compteurs as $tab)
        {
            $_tab['id'] = $tab->getId();
            $_tab['contrat'] = $tab->getContrat();
            $_tab['cumulAnc'] = $tab->getCumulAnc();
            $_tab['cumulNouv'] = $tab->getCumulNouv();
            $_tab['compteur'] = $tab->getCompteur();                        
            $compteur[] = $_tab;
        }
        return new JsonResponse($compteur);
    }
}
