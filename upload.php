<?php 
  /*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0", false);
  header("Cache-Control: max-age=0", false);
  header("Pragma: no-cache");*/
  
if(isset($_POST['upload'])){
    //Список разрешенных файлов
    $whitelist = array(".csv", ".jpeg", ".png", ".txt");         
    $data = array();
    $error = true;
    
    //Проверяем разрешение файла
    foreach  ($whitelist as  $item) {
        if(preg_match("/$item\$/i",$_FILES['userfile']['name'])) $error = false;
    }

    //если нет ошибок, грузим файл
    if(!$error) { 
                 
        $folder =  'C:/WWW/OpenServer/domains/webgis/csv/';//директория в которую будет загружен файл
        
        $uploadedFile =  $folder.basename($_FILES['userfile']['name']);
                
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
        
            if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadedFile)){
        
                $data['path'] = $folder;
				$data['name'] = $_FILES['userfile']['name'];
				
				
				if ( ($handle_o = fopen($data['path'].$data['name'], "r") ) !== FALSE ) 
					{
						$columns_o = fgetcsv($handle_o, 1000, ";");
						$datacsv = explode (",", $columns_o[0]);
					}
				else {$data['errors'] = "Не удалось открыть файл";}
				

            }
            else {    
                $data['errors'] = "Во время загрузки файла произошла ошибка";
            }
        }
        else {    
            $data['errors'] = "Файл не  загружен";
        }
    }
    else{
        
        $data['errors'] = 'Вы загружаете запрещенный тип файла';
    }
    
    
    //Формируем js-файл    
    $res = '<script type="text/javascript">';
    $res .= "var data = new Object;";
    foreach($data as $key => $value){
       $res .= 'data.'.$key.' = "'.$value.'";';
    }
	$radio = '';
		foreach($datacsv as $v) 
			{
			$radio = $radio.','.str_replace("\"", "", "$v");
			}			
			$radio = substr("$radio", 1);
			$res .= 'data.radio = "'.$radio.'";';

	
    $res .= 'window.parent.handleResponse(data);';
    $res .= "</script>";
    echo $res;
}
else{
    die("ERROR");
}

?>
