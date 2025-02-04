<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
//use Swift_Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\DependencyInjection\ExpressionLanguageProvider;


/**
 * @Route("/")
 */
class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="user_registration", methods={"GET","POST"})
     */
    public function registration(MailerInterface $mailer, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);


            $manager->persist($user);
            $manager->flush();

            /*
            $email = (new TemplatedEmail())
            
            ->from(new Address('contact@waloude.org', 'Waloude'))
            ->to(new Address($user->getEmail(), $user->getUsername()))
            ->subject('Confirmation de votre inscription Waloude!')
            ->htmlTemplate('email/welcome.html.twig')
            ->context([
                //'user' => $user,
            ]);

            $mailer->send($email);
            */



            return $this->redirectToRoute('app_login');

            
        }

        return $this->render('security/registration.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }


/**
 * @Route("/oubli-pass", name="app_forgotten_password")
 */
public function oubliPass(Request $request, UserRepository $users, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator
): Response
{
    // On initialise le formulaire
    $form = $this->createForm(ResetPassType::class);

    // On traite le formulaire
    $form->handleRequest($request);

    // Si le formulaire est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // On récupère les données
        $donnees = $form->getData();

        // On cherche un utilisateur ayant cet e-mail
        $user = $users->findOneByEmail($donnees['email']);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On envoie une alerte disant que l'adresse e-mail est inconnue
            $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
            
            // On retourne sur la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // On génère un token
        $token = $tokenGenerator->generateToken();

        // On essaie d'écrire le token en base de données
        try{
            $user->setResetToken($token);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());
            return $this->redirectToRoute('app_login');
        }

        // On génère l'URL de réinitialisation de mot de passe
        $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        // On génère l'e-mail
        $message = (new \Swift_Message('Mot de passe oublié'))
            ->setFrom('minkoueobamea@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Nouvelle-Techno.fr. Veuillez cliquer sur le lien suivant : " . $url,
                'text/html'
            )
        ;

        // On envoie l'e-mail
        $mailer->send($message);

        // On crée le message flash de confirmation
        $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

        // On redirige vers la page de login
        return $this->redirectToRoute('app_login');
    }

    // On envoie le formulaire à la vue
    return $this->render('security/forgotten_password.html.twig',['emailForm' => $form->createView()]);
}

/**
 * @Route("/reset_pass/{token}", name="app_reset_password")
 */
public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
{
    // On cherche un utilisateur avec le token donné
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['resetToken' => $token]);

    // Si l'utilisateur n'existe pas
    if ($user === null) {
        // On affiche une erreur
        $this->addFlash('danger', 'Token Inconnu');
        return $this->redirectToRoute('app_login');
    }

    // Si le formulaire est envoyé en méthode post
    if ($request->isMethod('POST')) {
        // On supprime le token
        $user->setResetToken(null);

        // On chiffre le mot de passe
        $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

        // On stocke
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // On crée le message flash
        $this->addFlash('message', 'Mot de passe mis à jour');

        // On redirige vers la page de connexion
        return $this->redirectToRoute('app_login');
    }else {
        // Si on n'a pas reçu les données, on affiche le formulaire
        return $this->render('security/reset_password.html.twig', ['token' => $token]);
    }

}

}
