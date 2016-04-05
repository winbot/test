<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;
  
class AdminPageController extends Controller
{
    public function loginAction()
    {
		//return new Response('<html><body>Admin page!</body></html>');
	    $request = $this->getRequest();
        $session = $request->getSession();
		
		//return new Response('<html><body>Admin page!</body></html>');
        
		// получить ошибки логина, если таковые имеются
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
		{
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
		else
		{
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
		
        return $this->render('FirstPageBundle:FirstPage:admin.html.twig', array(
            // имя, введённое пользователем в последний раз
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error, ));
		    //return $this->render('FirstPageBundle:FirstPage:admin.html.twig');
	}
	
	public function successAction()
    {
		return new Response('<html><body>Admin page!</body></html>');
	}
	
}