<?php

namespace First\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
            $response = array("code" => 100, "success" => true, "message" => $message);
            return new Response(json_encode($response));
        }else{
            $message = "Изменения не сохранены, повторите попытку!";
            $response = array("code" => 400, "success" => false, "message" => $message);
            return new Response(json_encode($response));
        }
    }

    public function readordersAjaxAction(Request $request)
    {
        //проверяем тип запроса если не XmlHttp то возвращаем код 400 и сообщение
       if (!$request->isXmlHttpRequest()) {
           return new JsonResponse(array('message' => 'Доступ разрешён только для запросов Ajax'), 400);
       }
        $req = $request->request->get('req');
        $status = $req[0];
        //Если status = 0 значит запрос на наличие не обработаных заказов
        if($status == 0) {
            //Производим поиск в таблице all_order всех не подтверждённых заказов
            $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
            $query = $repository->createQueryBuilder('q')
                ->where('q.accept = false')
                ->groupBy('q.ownerOrder')
                ->orderBy('q.ownerOrder', 'ASC')
                ->getQuery();
            $users = $query->getResult();
            $col_user = count($users);//количество посетителей выполнивших заказ

            if ($col_user != 0) {
                $user_name = $users[0]->getOwnerOrder();
                //Формируем список заказаных посетителем блюд
                $query = $repository->createQueryBuilder('q')
                    ->where('q.ownerOrder = \'' . $user_name . '\'')
                    ->andWhere('q.accept = false')
                    ->orderBy('q.id', 'ASC')
                    ->getQuery();
                $order_menu = $query->getResult();
                $col_item = count($order_menu);//количество блюд в заказе
                $dt = null;//Дата и время заказа
                $id_order = null;//Номер ордера заказа
                $username = null;//Хозяин заказа
                if ($col_item != 0) {
                    $dt = $order_menu[0]->getDateT();
                    $id_order = $order_menu[0]->getIdOrder();
                    $username = $order_menu[0]->getOwnerOrder();
                }

                $name = [];
                $portion = [];
                $cost = [];
                //Преобразуем дату в строку
                $dt = date_format($dt, "Y/m/d H:i:s");


                //Формируем массивы данных
                for ($i = 0; $i < $col_item; $i++) {
                    $name[$i] = $order_menu[$i]->getNameDishes();
                    $portion[$i] = $order_menu[$i]->getPortion();
                    $cost[$i] = $order_menu[$i]->getCost();
                }

                $response = array("success" => true, "dt" => $dt, "col_item" => $col_item,
                    "name_dishes" => $name, "portion" => $portion, "cost" => $cost,
                    "id_order" => $id_order, "username" => $username);
                return new Response(json_encode($response));
            } else {
                $response = array("success" => false);
                return new Response(json_encode($response));
            }
        }

        //Если status = 1 значит запрос на просмотр обработаных заказов
        if($status == 1) {
            //Показываем обработаные заказы
            //Получаем список посетителей чей заказ уже обработан
            $repository = $this->getDoctrine()->getRepository('FirstPageBundle:all_order');
            $query = $repository->createQueryBuilder('q')
                ->where('q.accept = true')
                ->groupBy('q.ownerOrder')
                ->addGroupBy('q.idOrder')
                ->orderBy('q.ownerOrder', 'ASC')
                ->getQuery();
            $users = $query->getResult();
            $col_user = count($users);//количество посетителей выполнивших заказ
            
            //Инициализируем переменные
            $dt = [];//Дата и время заказа
            $id_order = [];//Номер ордера заказа
            $username = [];//Хозяин заказа
            //Заполняем массисвы данными           
            if($col_user != 0){
                
                for($i = 0; $i < $col_user; $i++) {
                    $dtn = $users[$i]->getDateT();
                    //Преобразуем дату в строку
                    $dt[$i] = date_format($dtn, "Y/m/d H:i:s");
                    $id_order[$i] = $users[$i]->getIdOrder();
                    $username[$i] = $users[$i]->getOwnerOrder();
                }
                $response = array("success" => true, "dt" => $dt, "col_item" => $col_user,
                    "username" => $username, "id_order" => $id_order );
                return new Response(json_encode($response));
                
            }else{
                $response = array("success" => false);
                return new Response(json_encode($response));
            }

        }

        
    }

    public function readordersAction(Request $request)
    {
        return $this->render('FirstPageBundle:FirstPage:adminorders.html.twig');
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