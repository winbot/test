<?php

namespace First\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityAjaxController extends Controller
{
    public function loginAction(Request $request)
    {
        //проверяем тип запроса если не XmlHttp то возвращаем код 400 и message
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'Доступ разрешён только для запросов Ajax'), 400);
        }
        //Получаем имя пользователя и пароль из запроса
        $username = $request->request->get('name');
        $password = $request->request->get('password');
        //$tarray = json_decode($username, true);
        $t = $username[0];

        //Отправляем положительный ответ о входе в систему
        $response = array("code" => 100, "success" => true, "message" => $password, "info" => $t);

        return new Response(json_encode($response));

    }
}
