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
		//Получаем значения данных из запроса
		//Заполняем массив значениями id таблицы 'nametab'
		$arr = array();
		$col = $request->request->get('col');
		for($i = 0; $i<=$col; $i++){
			$id = $request->request->get('id'.$i);
			if($id != null)$arr[] = $id;
		}

		$nametab = $request->request->get('nametab');
		//создаём временную таблицу с именем пользователя
		$user = $this->getUser();
		$user_name = '';
        $state = null;//результат операции создания таблицы
		if($user) {
            $user_name = $user->getUsername(); //Получаем имя текущего пользователя
            $user_name = str_replace(" ","",$user_name);
            $em = $this->getDoctrine()->getEntityManager();
            $connection = $em->getConnection();
            $query = 'CREATE TABLE IF NOT EXISTS ' . $user_name . ' (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  portion VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  composition LONGTEXT COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;';
            $statement = $connection->prepare($query);
            //$statement = $connection->prepare('CREATE TABLE t (c CHAR(20) CHARACTER SET utf8 COLLATE utf8_bin);');
            $state = $statement->execute();
        }

		return $this->render('FirstPageBundle:FirstPage:test.html.twig', array(
			'nametab' => $nametab,
			'id' => $id[1],
			'col' => $col,
			'request' => $request,
			'arr' => $arr,
			'state' => $state,
		));
/*		$result = $this->getDoctrine()->getRepository('FirstPageBundle:main_menu')->findAll();
			if (!$result)
			{
				throw $this->createNotFoundException('No menu found ');
			}
			$col=count($result);
		    return $this->render('FirstPageBundle:FirstPage:index.html.twig', array(
				'result' => $result,
				'col' => $col,
			));*/
	}
	//Подтверждаем заказ
	public function confirmAction(Request $request)
	{
		$nametab = $request->request->get('nametab');
		//создаём временную таблицу с именем пользователя
		$user = $this->getUser();
		$user_name = '';
		$state = null;//результат операции создания таблицы
		if($user) {
			$user_name = $user->getUsername(); //Получаем имя текущего пользователя
			$em = $this->getDoctrine()->getEntityManager();
			$connection = $em->getConnection();
			$query = 'DROP TABLE ' . $user_name;
			$statement = $connection->prepare($query);
			$state = $statement->execute();
		}
	}
}