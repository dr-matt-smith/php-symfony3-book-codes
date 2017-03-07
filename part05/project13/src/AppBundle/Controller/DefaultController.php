<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // create colours array
        $colours = [
            'foreground' => 'blue',
            'background' => 'pink'
        ];

        // store colours in session 'colours'
        $session = new Session();
        $session->set('colours', $colours);

        $argsArray =  [
            'name' => 'matt'
        ];

        $templateName = 'index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/pop", name="pop")
     */
    public function popAction(Request $request)
    {
        return new Response('pop goes Symfony');
    }

}
