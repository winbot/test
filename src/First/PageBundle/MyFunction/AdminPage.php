<?php

namespace First\PageBundle\MyFunction;
use  First\PageBundle\Entity\main_menu;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    public static function exportMenu($name_tab)
    {
        $gk = $GLOBALS['kernel']->getContainer();
        $em =  $gk->get('doctrine')->getManager();

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

        //Получаем имя меню по имени таблицы
        //************************************
        $menu_name = $em->getRepository('FirstPageBundle:main_menu')->findOneBy(array ('nameTab' => $name_tab));
        if (!$menu_name)
        {
            throw $gk->createNotFoundException('No name menu found for '.$name_tab);
        }
        //************************************
        // Экспорт данных в файл xls
        $phpExcelObject = $gk->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Title")
            ->setSubject("Office 2005 XLSX Subject Document")
            ->setDescription("Export menu")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Export menu file");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', "id")
            ->setCellValue('B1', "Название")
            ->setCellValue('C1', "Количество гр.")
            ->setCellValue('D1', "Цена грн.")
            ->setCellValue('E1', "Описание");

        for($i=0; $i<$col_tabl; $i++) {
            $cell = $i+2;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'. $cell, $res_tabl[$i]->getId())
                ->setCellValue('B'. $cell, $res_tabl[$i]->getName())
                ->setCellValue('C'. $cell, $res_tabl[$i]->getPortion())
                ->setCellValue('D'. $cell, $res_tabl[$i]->getCost())
                ->setCellValue('E'. $cell, $res_tabl[$i]->getComposition());
        }
        $phpExcelObject->getActiveSheet()->setTitle('Order');
        // Устанавливаем индекс активной страницы
        $phpExcelObject->setActiveSheetIndex(0);

        // Создаём редактор
        $writer = $gk->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // Создвём ответ
        $response = $gk->get('phpexcel')->createStreamedResponse($writer);
        // Добавляем заголовок
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $name_tab . '.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    //Выполняем экспорт заказа
    public static function exportOrder($result)
    {
        $gk = $GLOBALS['kernel']->getContainer();

        //Получаем количество элементов в заказе
        $col_item = count($result);

        $allcost = 0.00;
        // Экспорт данных в файл xls
        $phpExcelObject = $gk->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Title")
            ->setSubject("Office 2005 XLSX Subject Document")
            ->setDescription("Export menu")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Export menu file");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('B1', "Название")
            ->setCellValue('C1', "Количество гр.")
            ->setCellValue('D1', "Цена грн.");
        for($i=0; $i<$col_item; $i++) {
            $cell = $i+2;
            $allcost += (float)$result[$i]->getCost();
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('B'. $cell, $result[$i]->getNameDishes())
                ->setCellValue('C'. $cell, $result[$i]->getPortion())
                ->setCellValue('D'. $cell, (float)$result[$i]->getCost());
        }
        $cell = $col_item+2;
        $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('D'. $cell, 'Всего к оплате: ' .$allcost. 'грн.');
            //->setCellValue('D20', $allcost);
        $phpExcelObject->getActiveSheet()->setTitle('Order');
        // Устанавливаем индекс активной страницы
        $phpExcelObject->setActiveSheetIndex(0);

        // Создаём редактор
        $writer = $gk->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // Создвём ответ
        $response = $gk->get('phpexcel')->createStreamedResponse($writer);
        // Добавляем заголовок
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'Order ' .$result[0]->getIdOrder(). ' ' .$result[0]->getOwnerOrder(). '.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;

    }
}