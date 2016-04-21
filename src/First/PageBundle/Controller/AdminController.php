<?php

namespace First\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use First\PageBundle\MyFunction\AdminPage;
use First\PageBundle\Entity\all_order;


class AdminController extends Controller
{

    public function exportAction(Request $request)
    {
        //Получаем из запроса имя таблицы
        $name_tab = $request->request->get('nametab');

        //Выполняем экспорт текущей таблицы
        $response = AdminPage::exportMenu($name_tab);

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

    public function readordersAction($order)
    {
        //Получаем список посетителей выполнивших заказ
        $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
        $query = $repository->createQueryBuilder('q')
            ->where('q.accept = false')
            ->groupBy('q.ownerOrder')
            ->orderBy('q.ownerOrder', 'ASC')
            ->getQuery();
            $users = $query->getResult();
        $col_user = count($users);//количество посетителей выполнивших заказ
        $user_name = $order;
        
        //Первый вход на страницу adminorders.html.twig
        //имя посетителя для просмотра заказа юудет первым из запроса 
        if($order == "first"){
            if($col_user != 0)$user_name = $users[0]->getOwnerOrder();
        }
        
        //Формируем список заказаных посетителем блюд
        $query = $repository->createQueryBuilder('q')
            ->where('q.ownerOrder = \'' .$user_name. '\'')
            ->andWhere('q.accept = false')
            ->orderBy('q.id', 'ASC')
            ->getQuery();
        $order_menu = $query->getResult();
        $col_item = count($order_menu);//количество блюд в заказе
        
        
        return $this->render('FirstPageBundle:FirstPage:adminorders.html.twig', array(
            'col_item' => $col_item,
            'order_menu' => $order_menu,
            'col_user' => $col_user,
            'user_name' => $user_name,
            'users' => $users,
        ));
    }
    public function exportorderAction(Request $request)
    {
        //Получаем из запроса имя пользователя
        $user_name = $request->request->get('username');
        //Получаем из запроса id заказа
        $id_order = $request->request->get('id_order');
        
        //Получаем данные для экспорта
        $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
        $query = $repository->createQueryBuilder('q')
            ->where('q.ownerOrder = \'' .$user_name. '\'')
            ->andWhere('q.idOrder = \'' .$id_order. '\'')
            ->getQuery();
        $result = $query->getResult();

        //Выполняем экспорт текущего заказа
        $response = AdminPage::exportOrder($result);

        return $response;        
    }
    public function acceptorderAction(Request $request)
    {
        //Получаем из запроса имя пользователя
        $user_name = $request->request->get('username');
        //Получаем из запроса id заказа
        $id_order = $request->request->get('id_order');

        //Подтверждаем обработку заказа
        $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
        $query = $repository->createQueryBuilder('q')
            ->update()
            ->set('q.accept',true)
            ->where('q.ownerOrder = \'' .$user_name. '\'')
            ->andWhere('q.idOrder = \'' .$id_order. '\'')
             ->getQuery();
        $result = $query->execute();

        //Переходим на страницу заказа (для посетителей сайта)
        return $this->redirect($this->generateUrl('readorders', array('order' => 'first')));
    }
}