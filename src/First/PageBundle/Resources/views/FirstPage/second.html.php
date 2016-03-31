<?php
 $view->extend('::base.html.php')
 ?>
<link rel="SHORTCUT ICON" href="favicon.ico">
Test Page number " 
<?php echo $view->escape($name) ?>"
for work with databse!
<br>
<?php
	
/*  	echo $view->escape($result[0]->getId());
	echo "<dt>";
	echo $view->escape($result[1]->getNamePage());
	echo "<dt>";
	echo $view->escape($result[2]->getNameTab());
	echo "<dt>";  */
	
	$i=count($result);
	echo "Элементов: [$i]";
	echo "<dt>";
	if($i == 1)
	{
		echo $view->escape($result->getId());
		echo " ";
		echo $view->escape($result->getNamePage());
		echo " ";
		echo $view->escape($result->getNameTab());
		echo "<dt>";
	}
	else
	{
		for($k=0; $k<$i; $k++)
		{
			echo $view->escape($result[$k]->getId());
			echo " ";
			echo $view->escape($result[$k]->getNamePage());
			echo " ";
			echo $view->escape($result[$k]->getNameTab());
			echo "<dt>";
		}
	}
?>