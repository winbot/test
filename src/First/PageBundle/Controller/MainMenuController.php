<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Doctrine\ORM\EntityRepository;

class MainMenuController extends Controller
{
    public function selectAction($name_tab)
    {
		if($name_tab == "hot_dishes_fish" || $name_tab == "cold_dishes_fish" || $name_tab == "dessert" || $name_tab == "cold_dishes_meat" || 
		$name_tab == "hot_snacks" || $name_tab == "main_dishes_meat" || $name_tab == "pasta" || $name_tab == "pizza" || 
		$name_tab == "salads" || $name_tab == "soup")
		{
			//Формируем массив с названиями меню
			//************************************
		    $res_menu = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$res_menu)
			{
				throw $this->createNotFoundException('Not found menu');
			}
			$col_menu = count($res_menu);
			//************************************
			
			//Формируем массив с детальным описанием меню
			//************************************
			$repo = 'FirstPageBundle:';
			$repo .= $name_tab;
			$res_tabl = $this->getDoctrine()->getRepository($repo)->findAll();
			if (!$res_tabl)
			{
				throw $this->createNotFoundException('Not found table Repository');
			}
			$col_tabl = count($res_tabl);
			//************************************
			
			//Получаем мвссив элементов в котором содержится имя текущего меню для вывода на страницу
			//************************************
			$menu_name = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findOneBy(array ('nameTab' => $name_tab));
			if (!$menu_name)
			{
				throw $this->createNotFoundException('No name menu found for '.$name_tab);
			}
			//************************************
			
			//Вызываем страницу
			//****************
			return $this->render('FirstPageBundle:FirstPage:detail_menu.html.twig', array('res_menu' => $res_menu, 'col_menu' => $col_menu,
			'res_tabl' => $res_tabl, 'col_tabl' => $col_tabl, 'menu_name' => $menu_name));
			//****************
		}
		else
		{
			return new Response('<html><body>Detail menu not found!</body></html>');
		}				
    }
}