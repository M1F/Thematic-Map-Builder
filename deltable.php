<?php
$conn_string = "host=localhost port=5432 dbname=webgis user=postgres password=aaa111222";
$dbconn4 = pg_pconnect($conn_string) or die("Невозможно установить соединение".mysql_error( ));

	//удаление таблицы
	$query1 = 'DROP TABLE "'.$_POST[fname].'"'; 
		$result1 = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
	//----------------------------------------------------------
	
?>

