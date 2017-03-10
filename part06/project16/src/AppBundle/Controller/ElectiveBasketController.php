<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Elective;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Elective controller.
 *
 * @Route("/basket")
 */
class ElectiveBasketController extends Controller
{
    /**
     * @Route("/", name="electives_basket_index")
     */
    public function indexAction()
    {
        // no need to put electives array in Twig argument array - Twig can get data direct from session
        $argsArray = [
        ];

        $templateName = 'basket/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }


    /**
     * @Route("/add/{id}", name="electives_basket_add")
     */
    public function addToElectiveCart(Elective $elective)
    {
        // default - new empty array
        $electives = [];

        // if no 'electives' array in the session, add an empty array
        $session = new Session();
        if($session->has('basket')){
            $electives = $session->get('basket');
        }

        // get ID of elective
        $id = $elective->getId();

        // only try to add to array if not already in the array
        if(!array_key_exists($id, $electives)){
            // append $elective to our list
            $electives[$id] = $elective;

            // store updated array back into the session
            $session->set('basket', $electives);
        }

        return $this->redirectToRoute('electives_basket_index');
    }


    /**
     * @Route("/clear", name="electives_basket_clear")
     */
    public function clearAction()
    {
        $session = new Session();
//        $session->clear();
        $session->remove('basket');

        return $this->redirectToRoute('electives_basket_index');
    }


    /**
     * @Route("/delete/{id}", name="electives_basket_delete")
     */
    public function deleteAction(int $id)
    {
        // default - new empty array
        $electives = [];

        // if no 'electives' array in the session, add an empty array
        $session = new Session();
        if($session->has('basket')){
            $electives = $session->get('basket');
        }

        // only try to remove if it's in the array
        if(array_key_exists($id, $electives)){
            // remove entry with $id
            unset($electives[$id]);

            if(sizeof($electives) < 1){
                return $this->redirectToRoute('electives_basket_clear');
            }

            // store updated array back into the session
            $session->set('basket', $electives);
        }

        return $this->redirectToRoute('electives_basket_index');
    }

}