<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Product controller.
 *
*/
class ProductBasketController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/basket/", name="basket_index")
     */
    public function indexAction()
    {
        $argsArray =  [
        ];

        $templateName = 'basket/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/basket/add/{id}", name="product_basket_add")
     */
    public function basketAddAction(Product $product)
    {
        $session = new Session();

        $basketProducts = [];

        if($session->has('basket')){
            //do something
            $basketProducts = $session->get('basket');
        }

        $id = $product->getId();

        if(!array_key_exists($id, $basketProducts)){
            $basketProducts[$id] = $product;

            $session->set('basket', $basketProducts);
        }

        return $this->redirectToRoute('basket_index');
    }

}
