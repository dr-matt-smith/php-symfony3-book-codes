<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{
    /**
     * login form
     *
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $session = new Session();

        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($this->canAuthenticate($user)) {
                // store user in session
                $session->set('user', $user);

                // redirect to ADMIN home page
                return $this->redirectToRoute('admin_index');
            } else {
                $this->addFlash(
                    'error',
                    'bad username or password, please try again'
                );

                // create new form with user that has no password - password should not be 'sticky'
                $user->setPassword('');
                $form = $this->createForm('AppBundle\Form\UserType', $user);

                // fall through to login form at end of this method
            }
        }

        $argsArray = [
            'user' => $user,
            'form' => $form->createView(),
        ];

        $templateName = 'login';

        return $this->render($templateName . '.html.twig', $argsArray);
    }

    private function createrLoginForm(User $user)
    {
        return $this->createForm('AppBundle\Form\UserType', $user);
    }


    /**
     * Creates a new user entity.
     *
     * @Route("/logout", name="logout")
     */

    public function logoutAction()
    {
        $session = new Session();

        if($session->has('user')){
            $session->remove('user');
        }

        // redirect to  home page
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param User $user
     *
     * @return bool
     *
     * return whether or not contents of $user is a valid username/password combination
     */
    public function canAuthenticate(User $user)
    {
        $username = $user->getUsername();
        $password = $user->getPassword();

        return ('admin' == $username) && ('admin' == $password);
    }
}
