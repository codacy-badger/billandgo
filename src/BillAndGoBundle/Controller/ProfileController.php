<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BillAndGoBundle\Controller;

use BillAndGoBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\OAuthServerBundle\Util\LegacyFormHelper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Controller managing the user profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $usersub = DefaultController::userSubscription($user, $this);
        if ($usersub["remaining"] <= 0) {
            $this->addFlash("error", $usersub["msg"]);
            return ($this->redirectToRoute("fos_user_security_login"));
        }

        return $this->render(
            '@FOSUser/Profile/show.html.twig',
            array(
            'user' => $user,
                "usersub" => DefaultController::userSubscription($user, $this)
            )
        );
    }



    /**
     * Edit the user.
     *
     * @param  Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $usersub = DefaultController::userSubscription($user, $this);
        if ($usersub["remaining"] <= 0) {
            $this->addFlash("error", $usersub["msg"]);
            return ($this->redirectToRoute("fos_user_security_login"));
        }
        /**
 * @var $dispatcher EventDispatcherInterface
*/
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle', 'attr'  => array('class' => 'form-control')))
            ->add('username', null, array('label' => 'Nom d\'utilisateur', 'translation_domain' => 'FOSUserBundle', 'attr'  => array('class' => 'form-control')))
            ->add('companyname', null, array('label' => 'Nom de votre société', 'attr'  => array('class' => 'form-control')))
            ->add('firstname', null, array('label' => 'Prénom', 'attr'  => array('class' => 'form-control')))
            ->add('lastname', null, array('label' => 'Nom', 'attr'  => array('class' => 'form-control')))
            ->add('address', null, array('label' => 'Adresse', 'attr'  => array('class' => 'form-control')))
            ->add('zip_code', null, array('label' => 'Code postal', 'attr'  => array('class' => 'form-control')))
            ->add('city', null, array('label' => 'Ville', 'attr'  => array('class' => 'form-control')))
            ->add('banque', null, array('label' => 'Banque', 'attr'  => array('class' => 'form-control')))
            ->add('siret', null, array('label' => 'Banque', 'attr'  => array('class' => 'form-control')))
            ->add('iban', null, array('label' => 'IBAN', 'attr'  => array('class' => 'form-control')))
            ->add('bic', null, array('label' => 'BIC', 'attr'  => array('class' => 'form-control')))
            ->add('country', null, array('label' => 'Pays', 'attr'  => array('class' => 'form-control')))
            ->add('phone', null, array('label' => 'Numéro de téléphone fixe', 'attr'  => array('class' => 'form-control')))
            ->add('mobile', null, array('label' => 'Numéro de téléphone mobile', 'attr'  => array('class' => 'form-control')))
            ->add('company_logo', null, array('label' => 'Logo', 'attr'  => array('class' => 'form-control'), 'required' => false))
            ->add('user_skin', null, array('label' => 'Photo de profil', 'attr'  => array('class' => 'form-control'), 'required' => false))
            ->add(
                'job_type',
                ChoiceType::class,
                array(
                'choices' => array(
                    'Freelance' => 'freelance',
                    'Micro-entrepreneur' => 'self-entrepreneur'
                ), 'attr'  => array('class' => 'form-control'), 'required' => false,  'placeholder' => 'Non défini'
                )
            )
            ->getForm();

        $form->handleRequest($request);

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $userFounded = $userRepo->findOneBy(array("username" => $user->getUsername()));


        if (null !== $userFounded && $userFounded->getId() != $user->getId()) {
            $form->addError(new FormError("Vous ne pouvez pas utiliser cet e-mail.".
                " Un utilisateur la possède déjà."));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $user->setEmail($user->getUsername());
            $user->setEmailCanonical($user->getUsername());
            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            return $response;
        }

        //$_SESSION['user_last_mjm_photo'] = $user->getCompanyLogo();
        return $this->render(
            '@FOSUser/Profile/edit.html.twig',
            array(
            'form' => $form->createView(), "user" => $user,
                "usersub" => DefaultController::userSubscription($user, $this)
            )
        );
    }


    public function uploadImage()
    {
        $extensions_valides = array( 'jpg' , 'png' );
        //1. strrchr renvoie l'extension avec le point (« . »).
        //2. substr(chaine,1) ignore le premier caractère de chaine.
        //3. strtolower met l'extension en minuscules.
        $extension_upload = strtolower(substr(strrchr($_FILES['icone']['name'], '.'), 1));
        if (in_array($extension_upload, $extensions_valides)) {
            exit("Extension correcte");
        }
    }
}
