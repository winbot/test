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
			$state1 = $statement->execute();
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
				for ($i = 0; $i <= $col; $i++) {
					$id_dishes = $request->request->get('id' . $i);
					$name_dishes = $request->request->get('name' . $i);
					$portion = $request->request->get('portion' . $i);
					$cost = floatval($request->request->get('cost' . $i));
					if ($id_dishes != null) {
						$query = 'INSERT INTO ' .$table_name. '(date_t, portion, id_dishes, name_dishes, cost, name_tab, user_name) VALUES (?,?,?,?,?,?,?);';
						$statement = $connection->prepare($query);
						$statement->bindValue(1, $date_time);
						$statement->bindValue(2, $portion);
						$statement->bindValue(3, $id_dishes);
						$statement->bindValue(4, $name_dishes);
						$statement->bindValue(5, $cost);
						$statement->bindValue(6, $name_tab);
						$statement->bindValue(7, $user_name);
						$state2 = $statement->execute();
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
		$em = $this->getDoctrine()->getEntityManager();
		$connection = $em->getConnection();
		//Создаём временную таблицу пользователя если не существует
		$query = 'CREATE TABLE IF NOT EXISTS ' . $user_name . ' (
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
		$statement->execute();
		//Выбираем все записи из таблицы $user_name
		$em = $this->getDoctrine()->getEntityManager();
		$connection = $em->getConnection();
		$query = 'SELECT * FROM ' . $user_name . ' WHERE 1 ;';
		$statement = $connection->prepare($query);
		$statement->execute();
		$results = $statement->fetchAll();
		$col = count($results);

		//Формируем страницу
		//****************
		$message ='';
		if($col == 0 )$message = 'Вы не выбрали ни одного блюда!';
		return $this->render('FirstPageBundle:FirstPage:previeworder.html.twig', array(
			'col' => $col,
			'results' => $results,
			'message' => $message,
		));
		//****************
	}

	//Изменение или подтверждение заказа
	public function update_confirmAction(Request $request)
	{
		//Получаем имя текущего пользователя
		$user = $this->getUser();
		//Прооверяем был выбран какое-либо блюдо из заказа для удаления
		$col = $request->request->get('col');
		$update = false;
		$result = null;
		for ($i = 0; $i <= $col; $i++) {
			$id = $request->request->get('id' . $i);
			if($id) {
				$update = true;//Выполняем изменения в таблице заказа
				break;
			}
		}
		//Выполняем изменения в таблице заказа
		if($user && $update) {
			//Получаем имя текущего пользователя
			$user_name = $user->getUsername();
			//Удаляем записи из таблицы $user_name
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			for ($i = 0; $i <= $col; $i++) {
				$id = $request->request->get('id' . $i);
				if ($id != null) {
					$query = 'DELETE FROM ' .$user_name. ' WHERE id=' . $id . ';';
					$statement = $connection->prepare($query);
					$statement->execute();
				}
			}

			//Перечитываем таблицу $user_name
			$query = 'SELECT * FROM ' . $user_name . ' WHERE 1 ;';
			$statement = $connection->prepare($query);
			$statement->execute();
			$results = $statement->fetchAll();
			$col = count($results);

			//Формируем страницу
			//****************
			$message = '';
			return $this->render('FirstPageBundle:FirstPage:previeworder.html.twig', array(
				'col' => $col,
				'results' => $results,
				'message' => $message,
			));
			//****************
		}else{
			//Отправляем заказ на выполнение
			//Получаем имя текущего пользователя
			$user_name = $user->getUsername();
			//Получаем данные из таблицы $user_name
			//*************************************
			$query = 'SELECT * FROM ' . $user_name . ' WHERE 1 ;';
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			$statement = $connection->prepare($query);
			$statement->execute();
			$results = $statement->fetchAll();
			$col = count($results);
			//*************************************
			//Получаем данные из таблицы $order
			//формеруем $id_order для текущего пользователя
			//*************************************
			$query = 'SELECT MAX(`id_order`) FROM `all_order` WHERE `owner_order` = \'' .$user_name. '\'';
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			$statement = $connection->prepare($query);
			$statement->execute();
			$id_ot = $statement->fetchAll();
			$id_order = $id_order = $id_ot[0]['MAX(`id_order`)']+1;
			//*************************************
			//Полученые данные записываем в общую таблицу заказов 'all_order'
			for ($i = 0; $i < $col; $i++) {
				$query = "INSERT INTO all_order(id_order, date_t, portion, id_dishes, name_dishes, cost, name_tab, owner_order, group_order, accept) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$statement = $connection->prepare($query);
				//Формируем дату и время отправки заказа
				$date_t = date("Y-m-d H:i:s");
				$statement->bindValue(1, $id_order);
				$statement->bindValue(2, $date_t);
				$portion = $results[$i]['portion'];
				$statement->bindValue(3, $portion);
				$id_dishes = (int)$results[$i]['id_dishes'];
				$statement->bindValue(4, $id_dishes);
				$name_dishes = $results[$i]['name_dishes'];
				$statement->bindValue(5, $name_dishes);
				$cost = (float)$results[$i]['cost'];
				$statement->bindValue(6, $cost);
				$name_tab = $results[$i]['name_tab'];
				$statement->bindValue(7, $name_tab);
				$statement->bindValue(8, $user_name);
				$group_order = 'gr_' . $user_name;
				$statement->bindValue(9, $group_order);
				$statement->bindValue(10, 0);
				$statement->execute();
			}
			//Удаляем временную таблицу $user_name
			$query = 'DROP TABLE IF EXISTS ' . $user_name;
			$statement = $connection->prepare($query);
			$statement->execute();
			//Формируем страницу принятого заказа
			$message = 'Ваш заказ принят и находится в обработке!';
			return $this->render('FirstPageBundle:FirstPage:previeworder.html.twig', array(
				'col' => $col,
				'results' => $results,
				'message' => $message,
			));
//			return new Response('<html><body>Заказ принят!</body></html>');
		}

	}
}