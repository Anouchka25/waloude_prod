<?php

namespace App\Controller;

use App\Entity\PhotoUser;
use App\Form\PhotoUserType;
use App\Repository\PhotoUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photo/user")
 */
class PhotoUserController extends AbstractController
{
    /**
     * @Route("/", name="photo_user_index", methods={"GET"})
     */
     public function index(PhotoUserRepository $photoUserRepository): Response
    {
        $userPhoto = $photoUserRepository->findBy(['user' => $this->getUser()]);

        return $this->render('photo_user/index.html.twig', [
            'photo_users' => $userPhoto,
        ]);
    } 

    /**
     * @Route("/new", name="photo_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $photoUser = new PhotoUser();
        $photoUser->setUser($this->getUser());

        $form = $this->createForm(PhotoUserType::class, $photoUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form['photo']->getData();

            if ($photoFile instanceof UploadedFile) {
                $photoName = $fileUploader->upload($photoFile);

                $photoUser->setPhoto($photoName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($photoUser);
            $entityManager->flush();

            return $this->redirectToRoute('moncompte');
        }

        return $this->render('photo_user/new.html.twig', [
            'photo_user' => $photoUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="photo_user_show", methods={"GET"})
     */
    public function show(PhotoUser $photoUser): Response
    {
        return $this->render('photo_user/show.html.twig', [
            'photo_user' => $photoUser,
        ]);
    } 

    /**
     * @Route("/{id}/edit", name="photo_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PhotoUser $photoUser, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PhotoUserType::class, $photoUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form['photo']->getData();

           $photoName = $fileUploader->upload($photoFile);

                //$this->setPhoto($photoName);
            
        
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('moncompte');
        }

        return $this->render('photo_user/edit.html.twig', [
            'photo_user' => $photoUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="photo_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PhotoUser $photoUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photoUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photoUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('moncompte');
    }
}
