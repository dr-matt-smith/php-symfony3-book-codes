<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Class AdminController
 * @package AppBundle\Controller
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();

        if ($session->has('user')){
            $templateName = '/admin/index';
            return $this->render($templateName . '.html.twig', []);
        }

        // if get here, not logged in, empty flash bag and create flash login first message then redirect
        $session->getFlashBag()->clear(); // avoids seeing message twice ...
        $this->addFlash(
            'error',
            'please login before accessing admin'
        );

        return $this->redirectToRoute('login');
    }
}
