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
        //проверяем тип запроса если не XmlHttp то возвращаем код 400 и сообщение
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'Доступ разрешён только для запросов Ajax'), 400);
        }
        //Получаем данные из запроса
        $name = $request->request->get('name');
        $composition = $request->request->get('composition');
        $portion = $request->request->get('portion');
        $cost = $request->request->get('cost');
        $name_tab = $request->request->get('nametab');
        $t = $name[0];// + " " + $composition[0] + " " + $portion[0] + " " + $cost[0];
        $col = count($name);//количество элементов в массиве

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
        $success = true;
        //Записываем изменённые данные в таблицу
        for ($i = 0; $i <$col; $i++) {
            $query = "INSERT INTO " . $name_tab . "(name, portion, cost, composition) VALUES (?,?,?,?)";
            $statement = $connection->prepare($query);
            $statement->bindValue(1, $name[$i]);
            $statement->bindValue(2, $portion[$i]);
            $statement->bindValue(3, $cost[$i]);
            $statement->bindValue(4, $composition[$i]);
            $success = $statement->execute();
        }


        
        //Отправляем положительный ответ о выполненых изменениях
        if($success){
            $message = "Изменения успешно прменены!";
            $response = array("code" => 100, "success" => true, "message" => $message, "info" => $t);
            return new Response(json_encode($response));
        }else{
            $message = "Изменения не сохранены, повторите попытку!";
            $response = array("code" => 400, "success" => false, "message" => $message, "info" => $t);
            return new Response(json_encode($response));
        }
            
        
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

    public function readordersAction($order, $orderstatus, $idorder)
    {

        if($orderstatus == 0 ) {//Показываем не обработаные заказы
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
            //имя посетителя для просмотра заказа будет первым из запроса
            if ($order == "first") {
                if ($col_user != 0) $user_name = $users[0]->getOwnerOrder();
            }

            //Формируем список заказаных посетителем блюд
            $query = $repository->createQueryBuilder('q')
                ->where('q.ownerOrder = \'' . $user_name . '\'')
                ->andWhere('q.accept = false')
                ->orderBy('q.id', 'ASC')
                ->getQuery();
            $order_menu = $query->getResult();
            $col_item = count($order_menu);//количество блюд в заказе
            $dt = null;//Дата и время заказа
            if($col_item !=0)$dt = $order_menu[0]->getDateT();
           
            return $this->render('FirstPageBundle:FirstPage:adminorders.html.twig', array(
                        'dt' => $dt,
                        'idorder' => $idorder,
                        'orderstatus' => $orderstatus,
                        'col_item' => $col_item,
                        'order_menu' => $order_menu,
                        'col_user' => $col_user,
                        'user_name' => $user_name,
                        'users' => $users,
                   ));
        }else{//Показываем обработаные заказы
            //Получаем список посетителей чей заказ уже обработан
            $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
            $query = $repository->createQueryBuilder('q')
                ->where('q.accept = true')
                ->groupBy('q.ownerOrder')
                ->addGroupBy('q.idOrder')
                ->orderBy('q.id', 'ASC')
                ->getQuery();
            $users = $query->getResult();
            $col_user = count($users);//количество посетителей выполнивших заказ
            $user_name = $order;
           
                
            //Первый вход на страницу adminorders.html.twig
            //имя посетителя для просмотра заказа будет первым из запроса
            if ($order == "first") {
                if ($col_user != 0){
                    $user_name = $users[0]->getOwnerOrder();
                    $idorder = $users[0]->getIdOrder();

                }
            }

            //Формируем список заказаных посетителем блюд
            $query = $repository->createQueryBuilder('q')
                ->where('q.ownerOrder = \'' . $user_name . '\'')
                ->andWhere('q.accept = true')
                ->andWhere('q.idOrder = ' . $idorder)
                ->orderBy('q.id', 'ASC')
                ->getQuery();
            $order_menu = $query->getResult();
            $col_item = count($order_menu);//количество блюд в заказе
            $dt = null;//Дата и время заказа
            if($col_item != 0)$dt = $order_menu[0]->getDateT();

            return $this->render('FirstPageBundle:FirstPage:adminorders.html.twig', array(
                'dt' => $dt,
                'idorder' => $idorder,
                'orderstatus' => $orderstatus,
                'col_item' => $col_item,
                'order_menu' => $order_menu,
                'col_user' => $col_user,
                'user_name' => $user_name,
                'users' => $users,
            ));
        }
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
        //Получаем из запроса статус заказа
        $order_status = $request->request->get('orderstatus');//Показываем не обработанные заказы если = 0
        //Получаем из запроса имя пользователя
        $user_name = $request->request->get('username');
        //Получаем из запроса id заказа
        $id_order = $request->request->get('id_order');

        //Подтверждаем обработку заказа
        $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
        $query = $repository->createQueryBuilder('q')
            ->update()
            ->set('q.accept', true)
            ->where('q.ownerOrder = \'' . $user_name . '\'')
            ->andWhere('q.idOrder = \'' . $id_order . '\'')
            ->getQuery();
        $result = $query->execute();

        //Переходим на страницу заказа (для посетителей сайта)
        return $this->redirect($this->generateUrl('readorders', array('order' => 'first', 'orderstatus' => 0, 'idorder' => 0)));
      }
}