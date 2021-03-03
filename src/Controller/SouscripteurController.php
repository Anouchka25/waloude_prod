<?php

namespace App\Controller;

use App\Entity\Souscripteur;
use App\Entity\User;
use App\Entity\Contrat;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use App\Entity\Enfant;
use App\Entity\Beneficiaire;
use App\Form\SouscripteurType;
use App\Form\ModifInfosType;
use Spipu\Html2Pdf\Html2Pdf;
use App\Service\T_HTML2PDF;
use App\Repository\SouscripteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/souscripteur")
 */
class SouscripteurController extends AbstractController
{
     /**
     * @Route("/prevoyance", name="prevoyance", methods={"GET"})
     */
    public function prevoyance(SouscripteurRepository $souscripteurRepository): Response
    {
        $userSouscripteur = $souscripteurRepository->findBy([
            'user' => $this->getUser()
            ]);

        return $this->render('souscripteur/prevoyance.html.twig', [
            'souscript' => $userSouscripteur,
        ]);
    }

    /**
     * @Route("/moncompte", name="moncompte", methods={"GET"})
     */
    public function moncompte(SouscripteurRepository $souscripteurRepository): Response
    {
        $userSouscripteur = $souscripteurRepository->findOneBy([
        'user' => $this->getUser()
        ]);
       // if($userSouscripteur!==null) {
            return $this->render('souscripteur/moncompte.html.twig', [
                'souscript' => $userSouscripteur,
            ]);
        //}else {
         //   return $this->redirectToRoute('souscripteur_new');
       // }

    }

    /**
     * @Route("/new", name="souscripteur_new", methods={"GET","POST"})
     */
    public function souscripteur(Request $request, 
    FileUploader $fileUploader1, 
    FileUploader $fileUploader2, 
    FileUploader $fileUploader3, 
    FileUploader $fileUploader4, 
    FileUploader $fileUploader5, 
    FileUploader $fileUploader6): Response
    {
        $souscripteur = new Souscripteur();
        $souscripteur->setUser($this->getUser());

        $ref = strtoupper (uniqid()); //uniqid — Génère un identifiant unique 
                                     //strtoupper — Renvoie une chaîne en majuscules
        $souscripteur->setReference($ref);

        /*$enfant = new Enfant();
        $souscripteur->addEnfant($enfant);

        $beneficiaire = new Beneficiaire();
        $souscripteur->addBeneficiaire($beneficiaire);*/

        $form = $this->createForm(SouscripteurType::class, $souscripteur);
        $form->handleRequest($request);

        if($souscripteur->getSituationFamiliale()!="marie" && 
                $souscripteur->getSituationFamiliale() !="pasce" && $souscripteur->getSituationFamiliale() !="concubin" ){
                    $souscripteur->setConjoint(null);
            }

        if ($form->isSubmitted() && $form->isValid()) {

            $cartrecto1File = $form->get('cartRecto1')->getData();
            $cartverso1File = $form->get('cartVerso1')->getData();

            $cartrecto2File = $form->get('cartRecto2')->getData();
            $cartverso2File = $form->get('cartVerso2')->getData();

            $compoMenageFile = $form->get('compoMenage')->getData();
            $autreDocFile = $form->get('autreDoc')->getData();

            if(isset($cartrecto1File)){
                $recto1fileName = $fileUploader1->upload($cartrecto1File);
                $souscripteur->setCartRecto1($recto1fileName);
            }
            
            if(isset($cartverso1File)){
                $verso1fileName = $fileUploader2->upload($cartverso1File);
                $souscripteur->setCartVerso1($verso1fileName);
            }
                
                if(isset($cartrecto2File)){
                    $recto2fileName = $fileUploader3->upload($cartrecto2File);
                    $souscripteur->setCartRecto2($recto2fileName);
                }
                if(isset($cartverso2File)){
                    $verso2fileName = $fileUploader4->upload($cartverso2File);
                    $souscripteur->setCartVerso1($verso2fileName);
                }
                if(isset($compoMenageFile)){
                    $compofileName = $fileUploader5->upload($compoMenageFile);
                    $souscripteur->setCompoMenage($compofileName);
                }
                if(isset($autreDocFile)){
                    $autrefileName = $fileUploader6->upload($autreDocFile);
                    $souscripteur->setAutreDoc($autrefileName);
                }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($souscripteur);
            $entityManager->flush();

            return $this->redirectToRoute('moncompte');
        }

        return $this->render('souscripteur/souscripteur.html.twig', [
            'souscript' => $souscripteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="souscripteur_show", methods={"GET"})
     */
    public function show(Souscripteur $souscripteur): Response
    {
        return $this->render('souscripteur/show.html.twig', [
            'souscripteur' => $souscripteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="souscripteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Souscripteur $souscripteur): Response
    {
        $form = $this->createForm(ModifInfosType::class, $souscripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('moncompte');
        }

        return $this->render('souscripteur/edit.html.twig', [
            'souscripteur' => $souscripteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="souscripteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Souscripteur $souscripteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$souscripteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($souscripteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('souscripteur_index');
    }

    /**
   * @Route("souscripteurpdf/{id}", name="souscripteurpdf", methods={"GET"})
     */
    public function showPdf(Souscripteur $souscripteur, ContratRepository $contratRepository): Response
    {

        $template = $this->render('souscripteur/souscripteurPDF.html.twig', [
            'souscripteur' => $souscripteur,
            //'contrats' => $contratRepository->findAll()
        ]);

      $html2pdf = new T_Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
      $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));

      return $html2pdf->generatePdf($template, "souscripteur");
    }
}
