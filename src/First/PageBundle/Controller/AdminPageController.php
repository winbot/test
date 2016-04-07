<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;
 use First\PageBundle\MyFunction\FixtureLoader;

 
  
class AdminPageController extends Controller
{
    public function loginAction()
    {
        /*FixtureLoader::load();*/
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'FirstPageBundle:FirstPage:admin.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    public function userAction()
    {
        return new Response('<html><body>User page!</body></html>');
    }

}