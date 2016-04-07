<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use First\PageBundle\MyFunction\Showdata;
 
class FirstPageController extends Controller
{
    public function indexAction()
    {
		$result = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$result)
			{
				throw $this->createNotFoundException('No menu found ');
			}
			$col=count($result);
		    return $this->render('FirstPageBundle:FirstPage:index.html.twig', array('result' => $result, 'col' => $col));
		}
}