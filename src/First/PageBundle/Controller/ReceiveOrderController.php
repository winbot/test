<?php

 namespace First\PageBundle\Controller;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
  
class ReceiveOrderController extends Controller
{
    //Обрабатываем данные отправленые в корзину
	public function receiveAction(Request $request)
	{
		//создаём временную таблицу с именем пользователя в названии
		$user = $this->getUser();
		$state1 = null;//результат операции создания таблицы
		$state2 = null;//результат операции записи в таблицу
		if ($user) {
			$table_name = $user->getUsername(); //Получаем имя текущего пользователя
			//$user_name = str_replace(" ", "", $user_name);// настроено фильтром на странице
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			$query = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
			  id INT(11) NOT NULL AUTO_INCREMENT,
			  date_t DATETIME NOT NULL,
			  portion VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
			  id_dishes INT(11) NOT NULL,
			  name_dishes VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
			  cost DECIMAL(10,2) NOT NULL,
			  name_tab VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
			  user_name VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;';
			$statement = $connection->prepare($query);
			//$statement = $connection->prepare('CREATE TABLE t (c CHAR(20) CHARACTER SET utf8 COLLATE utf8_bin);');
			$statement->execute();
			if ($state1) {
				//Заносим в таблицу данные о выбраных позициях
				//Формируем дату и время
				$date_time = date("Y-m-d H:i:s");
				//Имя текущего пользователя
				$user_name = $table_name;
				//Получаем значения данных из запроса
				//Название таблицы из основного меню
				$name_tab = $request->request->get('nametab');
				//Количество блюд в текущем меню
				$col = $request->request->get('col');
				//В цикле записываем в таблицу все позиции выбранные в текущем меню
				$element = null;
				for ($i = 0; $i <= $col; $i++) {
					$id_dishes = $request->request->get('id' . $i);
					$name_dishes = $request->request->get('name' . $i);
					$portion = $request->request->get('portion' . $i);
					$cost = floatval($request->request->get('cost' . $i));
					if ($id_dishes != null) {
						$query = 'INSERT INTO user1(date_t, portion, id_dishes, name_dishes, cost, name_tab, user_name) VALUES (?,?,?,?,?,?,?);';
						$statement = $connection->prepare($query);
						$statement->bindValue(1, $date_time);
						$statement->bindValue(2, $portion);
						$statement->bindValue(3, $id_dishes);
						$statement->bindValue(4, $name_dishes);
						$statement->bindValue(5, $cost);
						$statement->bindValue(6, $name_tab);
						$statement->bindValue(7, $user_name);
						$statement->execute();
					}
				}
			}
		}
		
		//Возвращаемся на страницу для продолжения заказа
		return $this->redirect($this->generateUrl('main_menu', array('name_tab' => $name_tab)));
	}

	//Просмотр заказа
	public function previeworderAction()
	{
		//Получаем имя текущего пользователя
		$user = $this->getUser();
		$user_name = $user->getUsername();
		//Выбираем все записи из таблицы $user_name
		$em = $this->getDoctrine()->getEntityManager();
		$connection = $em->getConnection();
		$query = 'SELECT * FROM ' . $user_name . ' WHERE 1 ;';
		$statement = $connection->prepare($query);
		$statement->execute();
		$results = $statement->fetchAll();
		$col = count($results);
		$el0 = $results[0]['name_dishes'];

/*		return $this->render('FirstPageBundle:FirstPage:test.html.twig', array(
			'nametab' => $nametab,
			'id' => $id[1],
			'req' => $request,
			'col' => $col,
			'el0' => $el0,
			'results' => $results,
		));*/

		//Формируем страницу
		//****************
		return $this->render('FirstPageBundle:FirstPage:previeworder.html.twig', array(
			'col' => $col,
			'results' => $results,
		));
		//****************
	}

	//Подтверждаем заказ
	public function confirmAction(Request $request)
	{
		//Получаем из запроса данные для обработки
		$nametab = $request->request->get('nametab');

		//Переносим данные о заказе из временной в общую таблицу заказов
		$user = $this->getUser();
		$user_name = '';
		$state = null;//результат операции создания таблицы
		if($user) {
			$user_name = $user->getUsername(); //Получаем имя текущего пользователя
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			$query = 'DROP TABLE IF EXISTS ' . $user_name;
			$statement = $connection->prepare($query);
			$state = $statement->execute();//Удаляем временную таблицу
		}
	}
}