<?php

 namespace First\PageBundle\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use First\PageBundle\MyFunction\CreateAccount;
 use First\PageBundle\Entity\main_menu;

 
  
class SecurityPageController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // Получаем ошибку входа
        $error = $authenticationUtils->getLastAuthenticationError();

        // Последнее введенное имя
        $lastUsername = $authenticationUtils->getLastUsername();
        
        //Проверяем имя пользователя (если уже зарегистрирован)
        //если администратор предоставляем возможность перехода на
        //страницу администрирования 
        $adm = false; //флаг 
        if($this->getUser()->getUsername() == "admin")$adm = true;

        return $this->render(
            'FirstPageBundle:FirstPage:account.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
                'adm'           => $adm,
            )
        );
    }

    public function adminAction()
    {
        //формируем страницу для администратора
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
        $col_menu = count($res_menu);

        //Получаем первое меню из списка для первичной инициализации страницы
        $name_tab = $res_menu[0]->getNameTab();

        //Формируем массив с детальным описанием меню
        //************************************
        $repo = 'FirstPageBundle:';
        $repo .= $name_tab;
        $res_tabl = $this->getDoctrine()->getRepository($repo)->findAll();
        if (!$res_tabl)
        {
            throw $this->createNotFoundException('Not found table Repository');
        }
        $col_tabl = count($res_tabl);
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
            ));
    }

    //Перенаправляем пользователя после регистрации 
    //eсли ADMIN то на админ. страницу, иначе на страницу оформления заказа
    public function accountAction()
    {
        //$user = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->getUser();
        $user_name = $user->getUsername(); //Получаем имя текущего пользователя
        if($user_name == "admin"){
            //ереходим на страницу администратора
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
            //Переходим на страницу заказа (для посетителей сайта)
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
        if ($username == "admin" || $username == "ADMIN" || $username == "Admin" ||
            $username == "user" || $username == "USER" || $username == "User") {
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