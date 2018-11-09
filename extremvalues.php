<?php
 /* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0", false);
  header("Cache-Control: max-age=0", false);
  header("Pragma: no-cache");*/
  
$conn_string = "host=localhost port=5432 dbname=webgis user=postgres password=aaa111222";
$dbconn4 = pg_pconnect($conn_string) or die("Невозможно установить соединение".mysql_error( ));

	//поиск максимального значения показателя
	//$selfeat = str_replace (' ','_',$_POST[selectedfeat]);
	$selfeat = $_POST[selectedfeat];
	$query = 'SELECT MAX (cast("'.$selfeat.'" as numeric)) FROM "'.$_POST[fname].'" '; 
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
		$result = pg_fetch_row($result, 0);
	//----------------------------------------------------------
	
	//поиск минимального значения показателя
	$query = 'SELECT MIN (cast("'.$selfeat.'" as numeric)) FROM "'.$_POST[fname].'" '; 
		$result1 = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
		$result1 = pg_fetch_row($result1, 0);
	//----------------------------------------------------------
			
	echo $result[0];
	echo ";".$result1[0];
?>

