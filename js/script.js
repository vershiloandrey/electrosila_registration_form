
$(document).ready(function(){
 	$("#phone").mask("+375 (99) 999-99-99");

	$("form button").click(function(){
		let error = 0;	// индикатор ошибок

		// валидация всех полей формы
		if ($("#name").val() == ""){
			$("#name").parent().addClass("error");
			error++;
		} else{
			$("#name").parent().removeClass("error");
		}
		if ($("#lastname").val() == ""){
			$("#lastname").parent().addClass("error");
			error++;
		} else{
			$("#lastname").parent().removeClass("error");
		}
		if (!$("#email").val().includes("@")){
			$("#email").parent().addClass("error");
			error++;
		} else{
			$("#email").parent().removeClass("error");
		}
		if(!$("#phone").val().match(/^(\+375) \((29|25|44|33)\) (\d{3})-(\d{2})-(\d{2})$/i)) {
			$("#phone").parent().addClass("error");
			error++;
		} else{
			$("#phone").parent().removeClass("error");
		}
		if ($("#password").val() != $("#confirm").val()){
			$("#password").parent().addClass("error");
			$("#confirm").parent().addClass("error")
			error++;
		} else{
			$("#password").parent().removeClass("error");
			$("#confirm").parent().removeClass("error");
		}

		// если ошибки, то выводим сообщение и завершаем скрипт
		// если ошибок нет, то скрываем ранее открытый текст (если был выведен)
		if (error != 0){
			$("#div-error").show();
			return;
		} else{
			$("#div-error").hide();
		}
	
		$.ajax({
	        url: "/ajax/action_ajax_form.php",
	        type: "GET",
	        data: {
	        	name: $("#name").val(),
	        	lastname: $("#lastname").val(),
	        	phone: $("#phone").val(),
	        	email: $("#email").val(),
	        	password: $("#password").val(),
	        	confirm: $("#confirm").val()
	    	},  

	        success: function(response) { 
	        	result = JSON.parse(response);

	        	// удаляем красное выделение полей для полей, где оно есть
	        	$(".error").each(function(item){
	        		item.removeClass("error");
	        	});

	        	// если из php вернулся массив, то это означает, что есть ошибки
	        	// проходим по массиву и выделяем поля с ошибкой
	        	if (Array.isArray(result)){
		        	if (result.length){
		        		result.forEach(function(currentValue){
		        			$(currentValue).parent().addClass("error");
		        		});
		        		$("#div-error").show();
		        	} 
		        // если вернулся не массив, то ошибок с вводом нет. анализируем ответ
		        } else {
		        	// если email занят, выделяем красным поле email
		        	if (result == "Пользователь с указанным вами Email уже существует."){
		        		$("#email").parent().addClass("error");
		        	} else if (result == "Регистрация пройдена успешно!"){
		        		$(".form-horizontal").hide();
		        	}
		        	// отображаем текст ответа с бэка
		        	$("#div-error").show();
		        	$("#div-error").children()[0].innerText = result;
		        }
		    },

		   	error: function(response) { 
	        	$('#result_form').html('Ошибка. Попробуйте позже.');
		    }
		});			
	});
});