<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $template = 'admin/index';
        return $this->render($template . '.html.twig', []);
    }

    /**
     * @Route("/codes", name="admin_codes")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function codesAction(Request $request)
    {
        $template = 'admin/codes';
        return $this->render($template . '.html.twig', []);
    }

}
