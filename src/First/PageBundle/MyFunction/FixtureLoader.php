<?php

namespace First\PageBundle\MyFunction;
use First\PageBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class FixtureLoader
{
	public static function load()
	{
		// создание пользователя
		//Получаем менеджер БД - Entity Manager
		$em =  $GLOBALS['kernel']->getContainer()->get('doctrine')->getManager();

		//Создаем экземпляр модели
		$user = new User;

		//Задаем значение полей
		$user->setUsername('admin');
		$user->setEmail('user@edu.com');
		$user->setisActive('1');
		$user->setRole('ROLE_ADMIN');

		// шифруем и устанавливаем пароль для пользователя,
		// эти настройки должны совпадать с конфигурационными файлами
/*		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$password = $encoder->encodePassword('admin', $user->getSalt());*/
		$encoderFactory = $GLOBALS['kernel']->getContainer()->get('security.encoder_factory');
		$encoder = $encoderFactory->getEncoder($user);

		$salt = '0123456789012345678901'; // this should be different for every user
		$password = $encoder->encodePassword('admin', $salt);

		$user->setSalt($salt);
		$user->setPassword($password);

		//Передаем менеджеру объект модели
		$em->persist($user);

		//Добавляем запись в таблицу
		$em->flush();
	}
}