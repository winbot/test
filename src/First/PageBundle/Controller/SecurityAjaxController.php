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
        $nametab = $request->request->get('nametab');
        $t = $name[0];// + " " + $composition[0] + " " + $portion[0] + " " + $cost[0];

        $message = "Изменения успешно прменены!";
        //Отправляем положительный ответ о входе в систему
        $response = array("code" => 100, "success" => true, "message" => $message, "info" => $t);
        return new Response(json_encode($response));
    }
}
