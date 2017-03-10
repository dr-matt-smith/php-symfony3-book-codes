<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Elective;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Elective controller.
 *
 * @Route("elective")
 */
class ElectiveController extends Controller
{
    /**
     * Lists all elective entities.
     *
     * @Route("/", name="elective_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $electives = $em->getRepository('AppBundle:Elective')->findAll();

        $argsArray = [
            'electives' => $electives,
        ];

        $templateName = 'elective/index';
        return $this->render($templateName . '.html.twig', $argsArray);
/*
        return $this->render('elective/index.html.twig', array(
            'electives' => $electives,
        ));
*/
    }

    /**
     * Creates a new elective entity.
     *
     * @Route("/new", name="elective_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $elective = new Elective();
        $form = $this->createForm('AppBundle\Form\ElectiveType', $elective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($elective);
            $em->flush($elective);

            return $this->redirectToRoute('elective_show', array('id' => $elective->getId()));
        }

        return $this->render('elective/new.html.twig', array(
            'elective' => $elective,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a elective entity.
     *
     * @Route("/{id}", name="elective_show")
     * @Method("GET")
     */
    public function showAction(Elective $elective)
    {
        $deleteForm = $this->createDeleteForm($elective);

        return $this->render('elective/show.html.twig', array(
            'elective' => $elective,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing elective entity.
     *
     * @Route("/{id}/edit", name="elective_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Elective $elective)
    {
        $deleteForm = $this->createDeleteForm($elective);
        $editForm = $this->createForm('AppBundle\Form\ElectiveType', $elective);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('elective_edit', array('id' => $elective->getId()));
        }

        return $this->render('elective/edit.html.twig', array(
            'elective' => $elective,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a elective entity.
     *
     * @Route("/{id}", name="elective_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Elective $elective)
    {
        $form = $this->createDeleteForm($elective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($elective);
            $em->flush($elective);
        }

        return $this->redirectToRoute('elective_index');
    }

    /**
     * Creates a form to delete a elective entity.
     *
     * @param Elective $elective The elective entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Elective $elective)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('elective_delete', array('id' => $elective->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
