<?php
 /* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0", false);
  header("Cache-Control: max-age=0", false);
  header("Pragma: no-cache");*/

$conn_string = "host=localhost port=5432 dbname=webgis user=postgres password=aaa111222";
$dbconn4 = pg_pconnect($conn_string)
or die("Невозможно установить соединение".mysql_error( ));
    //print ("Соединение с базой установлено.");
	
	//разбор массива с именами полей из csv
	$res .= '';
	$res1 .= '';
	foreach ($_POST[featall] as $allfealds)
	{
	    $allfealds = str_replace (' ','_',$allfealds); //new-----
		$allfealds1 = mb_strtolower($allfealds,'UTF-8');
		$res .= $allfealds1.' varchar,';
		$res1 .= $allfealds1.',';
	}
	$res = substr($res,0,-1);
	$res1 = substr($res1,0,-1);
	//----------------------------------------------------------
	
	//разбор массива с именами пользовательских полей из csv
		$res2 .= '';
	foreach ($_POST[feat] as $features)
	{
		$features = str_replace (' ','_',$features); //new-----
		$features = mb_strtolower($features,'UTF-8');
		$res2 .= $features.',';
	}
	$res2 = substr($res2,0,-1);
	//----------------------------------------------------------
	
	//создание таблицы сполями из csv
	$query = 'DROP TABLE IF EXISTS "'.$_POST[fname].'"';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	$query = 'CREATE TABLE "'.$_POST[fname].'" ('.$res.')'; 
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//----------------------------------------------------------
	
	//наполнение таблицы из csv		
	$query = 'COPY "'.$_POST[fname].'" ('.$res1.') 
		FROM \''.$_POST[fpath].$_POST[fname].'\'
		WITH DELIMITER \',\'
		CSV HEADER';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error()); 
	//----------------------------------------------------------
	
	//оптимизация для геокодирования	
	$region = mb_strtolower($_POST[reg],'UTF-8');
	$region = strtolower($region);
	$query = 'UPDATE "'.$_POST[fname].'" 
			SET '.$region.' = REPLACE ('.$region.',\' район\',\'\')';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());	
		
	$query = 'UPDATE "'.$_POST[fname].'" 
			SET '.$region.' = REPLACE ('.$region.',\' Район\',\'\')';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
		
	$query = 'UPDATE "'.$_POST[fname].'" 
			SET '.$region.' = REPLACE ('.$region.',\'ё\',\'е\')';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());	
	//----------------------------------------------------------
	
	//добавление геополя
	$query = 'ALTER TABLE "'.$_POST[fname].'" ADD geom geometry(MultiPolygon)';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//----------------------------------------------------------	
	
	//геокодирование
	$query = 'UPDATE "'.$_POST[fname].'" 
			SET geom = (SELECT "boundary-polygon".geom 
			FROM public."boundary-polygon"
			WHERE "'.$_POST[fname].'".'.$region.' = "boundary-polygon".name)';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//----------------------------------------------------------
	
	//замена запятых на точки
	if(($key = array_search($_POST[reg],$_POST[featall])) !== FALSE) {unset($_POST[featall][$key]);}
		foreach ($_POST[featall] as $allfealds)
			{
		$allfealds = str_replace (' ','_',$allfealds); //new-----
		$allfealds = mb_strtolower($allfealds,'UTF-8');
			$query = 'UPDATE "'.$_POST[fname].'" 
					SET '.$allfealds.' = REPLACE ('.$allfealds.',\',\',\'.\')';
				$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//удаление пробелов	
			$query = 'UPDATE "'.$_POST[fname].'" 
								SET '.$allfealds.' = REPLACE ('.$allfealds.',\' \',\'\')';
							$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
			$query = 'UPDATE "'.$_POST[fname].'" 
								SET '.$allfealds.' = REPLACE ('.$allfealds.', chr(160),\'\')';
							$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());							
			}
	//----------------------------------------------------------	
		
	//Преобразование табличных данных в geojson
	$query = 'SELECT row_to_json(fc)
			FROM ( SELECT \'FeatureCollection\' As type, array_to_json(array_agg(f)) As features
			FROM (SELECT \'Feature\' As type, ST_AsGeoJSON(lg.geom)::json As geometry, 
			row_to_json((SELECT l FROM (SELECT '.$region.', '.$res2.') As l)) As properties
			FROM "'.$_POST[fname].'" As lg   ) As f )  As fc';
		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//----------------------------------------------------------
	
	//Запись результата преобраования в файл
	$fp = fopen("gjson/".$_POST[fname].".js", "w");
	$varname =$_POST[fname];
	$varname = preg_replace('/\..*/','',$varname);
	fwrite($fp, "var ".$varname." = ");
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			foreach ($line as $col_value) {
				fwrite($fp, $col_value);}}
	fclose ($fp);
	//----------------------------------------------------------
		
	//максимумы
	//foreach ($_POST[feat] as $features)
	//{
	//	$query = 'SELECT MAX (cast("'.strtolower($features).'" as numeric)) FROM "'.$_POST[fname].'" '; 
	//		$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
	//	$max[strtolower($features)] = pg_fetch_row($result, 0);	
	//}
	//----------------------------------------------------------

	//echo $max["value"][0];	
	pg_close($dbconn4)
	 
?>