<?php

namespace AppBundle\Controller;

use AppBundle\Entity\County;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * County controller.
 *
 * @Route("county")
 */
class CountyController extends Controller
{
    /**
     * Lists all county entities.
     *
     * @Route("/", name="county_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $counties = $em->getRepository('AppBundle:County')->findAll();

        return $this->render('county/index.html.twig', array(
            'counties' => $counties,
        ));
    }

    /**
     * Creates a new county entity.
     *
     * @Route("/new", name="county_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $county = new County();
        $form = $this->createForm('AppBundle\Form\CountyType', $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($county);
            $em->flush($county);

            return $this->redirectToRoute('county_show', array('id' => $county->getId()));
        }

        return $this->render('county/new.html.twig', array(
            'county' => $county,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a county entity.
     *
     * @Route("/{id}", name="county_show")
     * @Method("GET")
     */
    public function showAction(County $county)
    {
        $deleteForm = $this->createDeleteForm($county);

        return $this->render('county/show.html.twig', array(
            'county' => $county,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing county entity.
     *
     * @Route("/{id}/edit", name="county_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, County $county)
    {
        $deleteForm = $this->createDeleteForm($county);
        $editForm = $this->createForm('AppBundle\Form\CountyType', $county);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('county_edit', array('id' => $county->getId()));
        }

        return $this->render('county/edit.html.twig', array(
            'county' => $county,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a county entity.
     *
     * @Route("/{id}", name="county_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, County $county)
    {
        $form = $this->createDeleteForm($county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($county);
            $em->flush($county);
        }

        return $this->redirectToRoute('county_index');
    }

    /**
     * Creates a form to delete a county entity.
     *
     * @param County $county The county entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(County $county)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('county_delete', array('id' => $county->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
