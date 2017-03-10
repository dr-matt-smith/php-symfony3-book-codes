<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Student;

class StudentController extends Controller
{

    /**
     * @Route("/students/list", name="students_list")
     */
    public function listAction(Request $request)
    {
        $studentRepository = $this->getDoctrine()->getRepository('AppBundle:Student');
        $students = $studentRepository->findAll();

        $argsArray = [
            'students' => $students
        ];

        $templateName = 'students/list';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Student $student
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Student $student)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Student (no queries yet)
        $em->persist($student);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->redirectToRoute('students_list');
    }

    /**
     * @Route("/students/delete/{id}", name="students_delete")
     */
    public function deleteAction($id)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        $studentRepository = $em->getRepository('AppBundle:Student');

        // find thge student with this ID
        $student = $studentRepository->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '.$id
            );
        }

        // tells Doctrine you want to (eventually) delete the Student (no queries yet)
        $em->remove($student);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        //return new Response('Deleted student with id '.$id);

        return $this->redirectToRoute('students_list');

    }



    /**
     * @Route("/students/show/{id}", name="students_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('AppBundle:Student')->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '.$id
            );
        }
        $argsArray = [
            'student' => $student
        ];

        $templateName = 'students/show';
        return $this->render($templateName . '.html.twig', $argsArray);
    }



    /**
     * @Route("/students/processNewForm", name="students_process_new_form")
     */
    public function processNewFormAction(Request $request)
    {
        // extract 'name' parameter from POST data
        $name = $request->request->get('name');

        if(empty($name)){
            $this->addFlash(
                'error',
                'student name cannot be an empty string'
            );

            // forward this to the createAction() method
            return $this->newFormAction($request);
        }

        // forward this to the createAction() method
        return $this->createAction($name);
    }


    /**
     * @Route("/students/new", name="students_new_form")
     */
    public function newFormAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $student = new Student();

        $form = $this->createFormBuilder($student)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Student'))
            ->getForm();


        /// ---- start processing POST submission of form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            return $this->createAction($student);
        }

        $argsArray = [
            'form' => $form->createView(),
        ];

        $templateName = 'students/new';
        return $this->render($templateName . '.html.twig', $argsArray);
    }



}
