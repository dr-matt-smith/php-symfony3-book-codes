<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $template = 'admin/index';
        $argsArray = [];

        return $this->render($template . '.html.twig', $argsArray);
    }

    /**
     * @Route("/codes", name="admin_codes")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function codeAction(Request $request)
    {
        $template = 'admin/codes';
        $argsArray = [];

        return $this->render($template . '.html.twig', $argsArray);
    }
}
