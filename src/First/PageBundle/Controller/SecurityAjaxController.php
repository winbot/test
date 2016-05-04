<?php

namespace First\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityAjaxController extends Controller
{
    public function loginAction(Request $request)
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
        //Записываем изменённые данные в таблицу
        for ($i = 0; $i <$col; $i++) {
                $query = "INSERT INTO " . $name_tab . "(name, portion, cost, composition) VALUES (?,?,?,?)";
                $statement = $connection->prepare($query);
                $statement->bindValue(1, $name[$i]);
                $statement->bindValue(2, $portion[$i]);
                $statement->bindValue(3, $cost[$i]);
                $statement->bindValue(4, $composition[$i]);
                $statement->execute();
        }


        $message = "Изменения успешно прменены!";
        //Отправляем положительный ответ о выполненых изменениях
        $response = array("code" => 100, "success" => true, "message" => $message, "info" => $t);
        return new Response(json_encode($response));
    }
}
