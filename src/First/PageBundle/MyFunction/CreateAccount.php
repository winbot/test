<?php

namespace First\PageBundle\MyFunction;
use Symfony\Component\HttpFoundation\Response;
use First\PageBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class CreateAccount
{

	public static function Create($username, $password, $email)
	{
		// создание пользователя
		//Получаем менеджер БД - Entity Manager
		$em =  $GLOBALS['kernel']->getContainer()->get('doctrine')->getManager();

		//Создаем экземпляр модели
		$user = new User;

    	//Проверяем существование пользователя с введеным именем
        //$_username = $this->getDoctrine()->getRepository('FirstPageBundle:user')->findOneBy(array ('username' => $username));
        $_username = $em->getRepository('FirstPageBundle:user')->findOneBy(array ('username' => $username));
        if($_username ){
            $error = 1;
            return $error;
        }
        //Проверяем на содержание введеные данные, если пусто - выходим 
        if($username == ''){
            $error = 3;
            return $error;
        }
        if($password == ''){
            $error = 4;
            return $error;
        }
		
        //Задаем значение полей
		$user->setUsername($username);
		$user->setEmail($email);
		$user->setisActive('1');
		$user->setRole('ROLE_USER');

		// шифруем и устанавливаем пароль для пользователя,
		// эти настройки должны совпадать с конфигурационными файлами
/*		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$password = $encoder->encodePassword('admin', $user->getSalt());*/
		$encoderFactory = $GLOBALS['kernel']->getContainer()->get('security.encoder_factory');
		$encoder = $encoderFactory->getEncoder($user);

		$salt = '0123456789012345678901'; // this should be different for every user
		$_password = $encoder->encodePassword($password, $salt);

		$user->setSalt($salt);
		$user->setPassword($_password);

		//Передаем менеджеру объект модели
		$em->persist($user);

		//Добавляем запись в таблицу
		$em->flush();
        
        return 0;
	}
}