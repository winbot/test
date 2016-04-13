<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use First\PageBundle\MyFunction\CreateAccount;
 use First\PageBundle\Entity\main_menu;

 
  
class SecurityPageController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // Получаем ошибку входа
        $error = $authenticationUtils->getLastAuthenticationError();

        // Последнее введенное имя
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'FirstPageBundle:FirstPage:account.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    public function adminAction()
    {
        //формируем страницу для администратора
        return new Response('<html><body>Admin page!</body></html>');
    }

    //Перенаправляем пользователя после регистрации 
    //eсли ADMIN то на админ. страницу, иначе на страницу оформления заказа
    public function accountAction()
    {
        //$user = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->getUser();
        $user_name = $user->getUsername(); //Получаем имя текущего пользователя
        if($user_name == "admin"){
            //Переходим на страницу администратора
            return $this->redirect($this->generateUrl('admin'));
        }
        else{
            //Получаем список меню
            //Формируем массив с названиями меню
            //************************************
            $res_menu = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
            if (!$res_menu)
            {
                throw $this->createNotFoundException('Not found menu');
            }
             //************************************
            //получаем количество экземпляров меню
            $col_tabl = count($res_menu);
            //Получаем первое меню из списка для первичной инициализации страницы
            if($col_tabl > 1){
                $name_tab = $res_menu[0]->getNameTab();
            }else{
                $name_tab = $res_menu->getNameTab();
            }
            //Переходим на страницу заказа (для обычных пользоваделей)
            return $this->redirect($this->generateUrl('main_menu', array('name_tab' => $name_tab)));
        }
     }
    
    //Формируем страницу с формой регистрации
    public function registrationAction()
    {
        $username = '';
        $email = '';
        $password = '';
        $message = '';
        $error = 0;
        return $this->render('FirstPageBundle:FirstPage:registration.html.twig',
            array(
                'error' => $error,
                'message' => $message,
                'username' => $username,
                'email' => $email,
                'password' => $password,                
            ));
    }
    
    //Обрабатываем POST запрос на создание нового аккаунта
    public function writeregdataAction(Request $request)
    {
        //Получаем значения данных из запроса 
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        $message = '';
        $error = 0;
        //Проверяем введеное посетителем имя для регистрации
        if ($username == "admin" || $username == "ADMIN" || $username == "Admin") {
            $message = "Вы ввели недопустимое имя!";
            $error = 2;
        } else {
            //Выполняем регистрацию посетителя
            $error = CreateAccount::Create($username, $password, $email);
            //Расшифровываем ошибки после оегистрации
            if ($error == 1) $message = "Введеное Вами имя уже используется!";
            if ($error == 3) $message = "Поле ИМЯ не должно быть пустым!";
            if ($error == 4) $message = "Поле ПАРОЛЬ не должно быть пустым!";
            if ($error == 0) $message = "Регистрация прошла успешно, выполните вход в систему заказов!";
        }

        //Формируем страницу регистрации для продолжения работы
        //(вход или исправление ошибок при регистрации)
        return $this->render('FirstPageBundle:FirstPage:registration.html.twig',
            array(
                'error' => $error,
                'message' => $message,
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ));
    }
}