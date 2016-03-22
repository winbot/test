<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class SecondPageController extends Controller
{
    public function indexAction($name)
    {
		if($name=="1")
		{
		    return new Response('<html><body>First page:'.$name.'!</body></html>');
		}
		elseif($name=="2")
		{
		    //return new Response('<html><body>Second page!</body></html>');
			return $this->render('FirstPageBundle:Default:index.html.twig', array('name' => $name));
		}
		elseif($name=="3")
		{
		    return $this->render('FirstPageBundle:FirstPage:index.html.twig', array('name' => $name));
		}
		elseif($name=="4")
		{
		    return $this->render('FirstPageBundle:FirstPage:index.html.php', array('name' => $name));
		}
		elseif($name=="5")
		{
			$result = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->find('2');
			//$result = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$result)
			{
				throw $this->createNotFoundException('No product found for id ');
			}
			return $this->render('FirstPageBundle:FirstPage:base.html.php',array('name' => $name, 'result' => $result));
		}
		else
		{
			return new Response('<html><body>Page not found!</body></html>');
		}				
    }
	
	public function showAction()
	{
		
	}
}