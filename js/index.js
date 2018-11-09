		function hideBtn(){
            $('#upload').hide();
            $('#res').html("Идет загрузка файла");
        }
        
        function handleResponse(mes) 
		{
            $('#upload').show();
            if (mes.errors != null) {
                $('#res').html("Возникли ошибки во время загрузки файла: " + mes.errors);
            }    
            else {
				$('#res').html("Файл успешно загружен");				
				var csvtitle = mes.radio.split(',');
				var count = csvtitle.length;
				
					for ( var i = 0; i < count; i++ ) 
						{
							$('#res2').append("<input type='radio' name='region' value='"+csvtitle[i]+"' />" +csvtitle[i]);
						}									
				
					for ( var i = 0; i < count; i++ ) 
						{
							$('#res3').append("<input type='checkbox' name='feature' value='"+csvtitle[i]+"' />" +csvtitle[i]);
						}			
				$('#fname').val(mes.name);
				$('#fpath').val(mes.path);
				//$('#res').html("Файл " + mes.radio + " загружен"); 	
				
            }    
        }
		
						
		function importer(){		
			var feature = [];			 					
				$("#res3 input:checked").each(function() {feature.push($(this).val());});	
			//var feat = feature.join(',');
			var featall = [];			 					
				$("#res3 :checkbox").each(function() {featall.push($(this).val());});	
			var reg = $("#res2 input:checked").val();
			var fname = $("#fname").val();
			var fpath = $("#fpath").val();
					//if(reg && feat){
					//	alert("You have selected " + reg+" and "+feat);
					//}else{
					//	alert("Вы не отметили необходимые поля");  
					//}
 
 
			$.ajax({
				type: "POST",
				url:'import.php',
				data:{
				feat: feature,
				featall: featall,
				reg: reg,
				fname: fname,
				fpath: fpath
				},
			
				success:function(data){
				  $('#res3').html(data); 
				  
				},
				failure: function() {
					alert("Ajax request broken");
				}			   
			});
			
			//return false; // to prevent from page reload
			};