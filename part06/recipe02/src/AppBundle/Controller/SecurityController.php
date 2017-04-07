<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils'); // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError(); // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
// Twig stuff
        $templateName = 'security/login';
        $argsArray = [
            'last_username' => $lastUsername,
            'error' => $error,];
        return $this->render($templateName . '.html.twig', $argsArray);
    }
}
