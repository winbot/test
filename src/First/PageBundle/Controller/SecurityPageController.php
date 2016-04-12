<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;
 use First\PageBundle\MyFunction\FixtureLoader;
 use First\PageBundle\MyFunction\CreateAccount;
 use Symfony\Component\HttpFoundation\Request;

 
  
class SecurityPageController extends Controller
{
    public function loginAction()
    {
        /*FixtureLoader::load();*/
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'FirstPageBundle:FirstPage:account.html.twig',
            array(
                // last username entered by the user
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

    public function userAction()
    {
        //формируем страницу для оформления заказа
        return new Response('<html><body>User page!</body></html>');
    }

    public function accountAction()
    {
        //$user = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->getUser();
        $user_name = $user->getUsername(); //Получаем имя текущего пользователя
        if($user_name == "admin"){
            //Переходим на страницу администратора(для администратора)
            return $this->redirect($this->generateUrl('admin'));
        }
        else{
            //Переходим на страницу заказа (для обычных пользоваделей)
            return $this->redirect($this->generateUrl('user'));
        }
     }
    
    //Формируем страницу регистрации
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
            if ($error == 0) $message = "Регистрация прошла успешно, выпоните вход в систему!";
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

//        return $this->render('FirstPageBundle:FirstPage:registration.html.twig', array('message' => $message));
    }
}