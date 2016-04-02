<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use First\PageBundle\MyFunction\Showdata;
 
class FirstPageController extends Controller
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
			$result = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$result)
			{
				throw $this->createNotFoundException('No menu found ');
			}
			$col=count($result);
		    return $this->render('FirstPageBundle:FirstPage:index.html.twig', array('result' => $result, 'col' => $col));
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
				throw $this->createNotFoundException('Menu not found');
			}
			//$name = $this->showAction("1");
			//$f = new Showdata();
			$name = Showdata::showFunction("new page");
			return $this->render('FirstPageBundle:FirstPage:second.html.php',array('name' => $name, 'result' => $result));
		}
		else
		{
			return new Response('<html><body>Page not found!</body></html>');
		}				
    }
	
	public function showAction($n)
	{
		$str = $n;
		return $str;
	}
}