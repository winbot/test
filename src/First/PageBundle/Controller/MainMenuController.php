<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class MainMenuController extends Controller
{
    public function selectAction($name_tab)
    {
		if($name_tab == "hot_dishes_fish" || $name_tab == "cold_dishes_fish" || $name_tab == "dessert" || $name_tab == "cold_dishes_meat" || 
		$name_tab == "hot_snacks" || $name_tab == "main_dishes_meat" || $name_tab == "pasta" || $name_tab == "pizza" || 
		$name_tab == "salads" || $name_tab == "soup")
		{
		    $res_menu = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$res_menu)
			{
				throw $this->createNotFoundException('No menu found ');
			}
			$repo = 'FirstPageBundle:';
			$repo .= $name_tab;
			$res_tabl = $this->getDoctrine()->getRepository($repo)->findAll();
			if (!$res_tabl)
			{
				throw $this->createNotFoundException('No hot_dishes_fish found ');
			}
			$col_menu=count($res_menu);
			$col_tabl=count($res_tabl);
			return $this->render('FirstPageBundle:FirstPage:detail_menu.html.twig', array('res_menu' => $res_menu, 'col_menu' => $col_menu,
			'res_tabl' => $res_tabl, 'col_tabl' => $col_tabl));
		}
		elseif($name_tab=="2")
		{
		    return $this->render('FirstPageBundle:Default:index.html.twig', array('name' => $name_tab));
		}
		else
		{
			return new Response('<html><body>Detail menu not found!</body></html>');
		}				
    }
}