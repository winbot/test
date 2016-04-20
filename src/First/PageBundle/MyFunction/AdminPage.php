<?php

namespace First\PageBundle\MyFunction;
use  First\PageBundle\Entity\main_menu;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminPage
{

    public static function CreateMenu($name_tab)
    {
        //Получаем список меню
        //Формируем массив с названиями меню
        //************************************
        $gk = $GLOBALS['kernel']->getContainer();
        $em =  $gk->get('doctrine')->getManager();
        $res_menu = $em->getRepository('FirstPageBundle:main_menu')->findAll();
        if (!$res_menu)
        {
            throw $gk->createNotFoundException('Not found menu');
        }
        //************************************
        //получаем количество групп меню
        $col_menu = count($res_menu);

        //Формируем массив с детальным описанием меню
        //************************************
        $repo = 'FirstPageBundle:';
        $repo .= $name_tab;
        $res_tabl = $em->getRepository($repo)->findAll();
        if (!$res_tabl)
        {
            throw $gk->createNotFoundException('Not found table Repository');
        }
        $col_tabl = count($res_tabl);//количество элементов в меню
        //************************************

        //Получаем мвссив элементов в котором содержится имя текущего меню для вывода на страницу
        //************************************
        $menu_name = $em->getRepository('FirstPageBundle:main_menu')->findOneBy(array ('nameTab' => $name_tab));
        if (!$menu_name)
        {
            throw $gk->createNotFoundException('No name menu found for '.$name_tab);
        }
        //************************************
        //В массив $res записываем возвращаемые данные
        //************************************
        $res = array();
        array_push($res, $res_menu);
        array_push($res, $res_tabl);
        array_push($res, $menu_name);
        //************************************

        return $res;
    }
}