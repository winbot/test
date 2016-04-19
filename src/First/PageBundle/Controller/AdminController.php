<?php

namespace First\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use First\PageBundle\MyFunction\MenuAdminPage;


class AdminController extends Controller
{

    public function exportAction()
    {
        // Экспорт данных в файл xls
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
        ->setLastModifiedBy("Admin")
        ->setTitle("Office 2005 XLSX Title Document")
        ->setSubject("Office 2005 XLSX Subject Document")
        ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
        ->setKeywords("office 2005 openxml php")
        ->setCategory("Test result file");
        $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Hello')
        ->setCellValue('B1', 'world!');
        $phpExcelObject->getActiveSheet()->setTitle('Order');
        // Устанавливаем индекс активной страницы
        $phpExcelObject->setActiveSheetIndex(0);

        // Создаём редактор
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // Создвём ответ
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // Добавляем заголовок
        $dispositionHeader = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'export-data.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    //Вносим изменения в таблицу выбраного меню
    public function update_menuAction(Request $request)
    {
        //Получаем имя текущей таблицы
        $name_tab = $request->request->get('nametab');
        //Количество строк в таблице
        $col = $request->request->get('col');
        //Удаляем все записи в таблице
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $query = "DELETE FROM " .$name_tab. " WHERE id<>0";
        $statement = $connection->prepare($query);
        $statement->execute();

        //Обнуляем счётчик id таблицы
        $query = "ALTER TABLE " .$name_tab. " AUTO_INCREMENT=1";
        $statement = $connection->prepare($query);
        $statement->execute();
        //Записываем изменённые данные в таблицу
        for ($i = 0; $i <=$col; $i++) {
            $query = "INSERT INTO " .$name_tab. "(name, portion, cost, composition) VALUES (?,?,?,?)";
            $statement = $connection->prepare($query);
            $name = $request->request->get('name' . $i);
            $portion = $request->request->get('portion' . $i);
            $cost = (float)$request->request->get('cost' . $i);
            $composition = $request->request->get('composition' . $i);
            $statement->bindValue(1, $name);
            $statement->bindValue(2, $portion);
            $statement->bindValue(3, $cost);
            $statement->bindValue(4, $composition);
            $statement->execute();
        }

        //Выполняем функцию получения данных для формирования
        // страницы администратора
        $temp = MenuAdminPage::CreateMenu($name_tab);
        //Получаем данные из массива $temp
        $res_menu = $temp[0];
        $res_tabl = $temp[1];
        $menu_name = $temp[2];
        $col_menu = count($res_menu);//получаем количество групп меню
        $col_tabl = count($res_tabl);//количество элементов в меню
        //Переходим на страницу администратора
        return $this->render('FirstPageBundle:FirstPage:admin.html.twig', array(
            'res_menu' => $res_menu,
            'col_menu' => $col_menu,
            'res_tabl' => $res_tabl,
            'col_tabl' => $col_tabl,
            'menu_name' => $menu_name,
        ));
    }

    //добавляем элемент в таблицу выбраного меню
    public function add_item_menuAction(Request $request)
    {
        //Получаем имя текущей таблицы
        $name_tab = $request->request->get('nametab');

        //Добавляем пустую строку в текущую таблицу
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $query = "INSERT INTO " .$name_tab. "(name, portion, cost, composition) VALUES (?,?,?,?)";
        $statement = $connection->prepare($query);
        $statement->bindValue(1, '');
        $statement->bindValue(2, '');
        $statement->bindValue(3, '');
        $statement->bindValue(4, '');
        $statement->execute();
        //Выполняем функцию получения данных для формирования
        // страницы администратора
        $temp = MenuAdminPage::CreateMenu($name_tab);

        /*//Получаем список меню
        //Формируем массив с названиями меню
        //************************************
        $res_menu = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
        if (!$res_menu)
        {
            throw $this->createNotFoundException('Not found menu');
        }
        //************************************
        //получаем количество групп меню
        $col_menu = count($res_menu);

        //Формируем массив с детальным описанием меню
        //************************************
        $repo = 'FirstPageBundle:';
        $repo .= $name_tab;
        $res_tabl = $this->getDoctrine()->getRepository($repo)->findAll();
        if (!$res_tabl)
        {
            throw $this->createNotFoundException('Not found table Repository');
        }
        $col_tabl = count($res_tabl);//количество элементов в меню
        //************************************

        //Получаем мвссив элементов в котором содержится имя текущего меню для вывода на страницу
        //************************************
        $menu_name = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findOneBy(array ('nameTab' => $name_tab));
        if (!$menu_name)
        {
            throw $this->createNotFoundException('No name menu found for '.$name_tab);
        }
        //************************************

        //Переходим на страницу администратора
        return $this->render('FirstPageBundle:FirstPage:admin.html.twig', array(

            'res_menu' => $res_menu,
            'col_menu' => $col_menu,
            'res_tabl' => $res_tabl,
            'col_tabl' => $col_tabl,
            'menu_name' => $menu_name,
        ));*/
        $res_menu = $temp[0];
        $res_tabl = $temp[1];
        $menu_name = $temp[2];
        $col_menu = count($res_menu);//получаем количество групп меню
        $col_tabl = count($res_tabl);//количество элементов в меню
        //Переходим на страницу администратора
        return $this->render('FirstPageBundle:FirstPage:admin.html.twig', array(
            'res_menu' => $res_menu,
            'col_menu' => $col_menu,
            'res_tabl' => $res_tabl,
            'col_tabl' => $col_tabl,
            'menu_name' => $menu_name,
        ));
 /*       return $this->render('FirstPageBundle:FirstPage:test.html.twig', array(
            'menu_name' => $menu_name,
            'res_tabl' => $res_tabl,
            'res_menu' => $res_menu,
            'temp' => $temp,
        ));*/
        
    }
}