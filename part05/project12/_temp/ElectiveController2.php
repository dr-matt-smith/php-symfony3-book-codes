<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 03/03/2017
 * Time: 11:36
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use AppBundle\Entity\Elective;
use Symfony\Component\HttpFoundation\Session\Session;

class ElectiveController2 extends Controller
{

    /**
     * @Route("/electives/add/{id}", name="electives_add")
     */
    public function addToElectiveCart($id)
    {
        // get elecrtive record relating to given ID
        $elective = $this->getDoctrine()->getRepository('AppBundle:Elective')->find($id);

        // Exception - no elective matching given ID
        if(!$elective){
            throw $this->createNotFoundException(
                'No elective found for id '.$id
            );
        }

        // default - new empty array
        $electives = [];

        // if no 'electives' array in the session, add an empty array
        $session = new Session();
        if($session->has('electives')){
            $electives = $session->get('electives');
        }


        // only try to add to array if not already in the array
        if(!array_key_exists($id, $electives)){
            // append $elective to our list
            $electives[$id] = $elective;

            // store updated array back into the session
            $session->set('electives', $electives);
        }

        return $this->redirectToRoute('electives_list');
    }

    /**
     * @Route("/electives/list", name="electives_list")
     */
    public function listAction()
    {
        // no need to put electives array in Twig argument array - Twig can get data direct from session
        $argsArray = [
        ];

        $templateName = 'electives/list';
        return $this->render($templateName . '.html.twig', $argsArray);
    }


    /**
     * @Route("/electives/clear", name="electives_clear")
     */
    public function clearAction()
    {
        $session = new Session();
        $session->remove('electives');

        $session->clear();

        return $this->redirectToRoute('electives_list');
    }


}