<?php

namespace First\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use First\PageBundle\MyFunction\AdminPage;


class AdminController extends Controller
{

    public function exportAction(Request $request)
    {
        //Получаем из запроса имя таблицы
        $name_tab = $request->request->get('nametab');

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

        //Получаем имя меню по имени таблицы
        //************************************
        $menu_name = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findOneBy(array ('nameTab' => $name_tab));
        if (!$menu_name)
        {
            throw $this->createNotFoundException('No name menu found for '.$name_tab);
        }
        //************************************
        // Экспорт данных в файл xls
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
        ->setLastModifiedBy("Admin")
        ->setTitle("Title Title")
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
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // Создвём ответ
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
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
            $id = $request->request->get('id' . $i);
            if(!$id) {//Если позиция в меню не была отмечена для удаления, то заносим её в таблицу
                $query = "INSERT INTO " . $name_tab . "(name, portion, cost, composition) VALUES (?,?,?,?)";
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
        }

        //Выполняем функцию получения данных для формирования
        // страницы администратора
        $temp = AdminPage::CreateMenu($name_tab);
        //Извлекаем из полученного массива данные
        $res_menu = $temp[0];//Группы меню
        $res_tabl = $temp[1];//Состав текущего меню
        $menu_name = $temp[2];//Имя текущего меню
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
        $temp = AdminPage::CreateMenu($name_tab);

        //Извлекаем из полученного массива данные
        $res_menu = $temp[0];//Группы меню
        $res_tabl = $temp[1];//Состав текущего меню
        $menu_name = $temp[2];//Имя текущего меню
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
}