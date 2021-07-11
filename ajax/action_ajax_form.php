<?php

	require_once('../class/Logger.php');

	if (isset($_GET['name']) && isset($_GET['lastname']) && isset($_GET['phone']) && 
		isset($_GET['email']) && isset($_GET['password']) && isset($_GET['confirm'])){
		// преобразования специмволов
		$name = htmlspecialchars($_GET["name"], ENT_QUOTES);
		$lastname = htmlspecialchars($_GET["lastname"], ENT_QUOTES);
		$phone = htmlspecialchars($_GET["phone"], ENT_QUOTES);
		$email = htmlspecialchars($_GET["email"], ENT_QUOTES);
		$password = htmlspecialchars($_GET["password"], ENT_QUOTES);
		$confirm = htmlspecialchars($_GET["confirm"], ENT_QUOTES);
		$error = [];	// массив для ошибок, чтобы понимать, какие поля выделять красным

		if (!stripos($email, "@")){
			$error[] = "#email";
		}
		if (!preg_match("/^(\+375) \((29|25|44|33)\) (\d{3})-(\d{2})-(\d{2})$/i", $phone)){
			$error[] = "#phone";
		}
		if ($confirm != $password){
			$error[] = "#password";
			$error[] = "#confirm";
		}

		if (!$error){	// если нет ошибок в заполнении полей

			// массив зарегистрированных пользователей
			$array_users = array(
				array('id' => 0, 'name' => "Jack", 'email' => "jack@mail.ru"), 	
				array('id' => 1, 'name' => "Andrey", 'email' => "Andrey@mail.ru"),
				array('id' => 2, 'name' => "Admin", 'email' => "admin@admin.ru")
			);

			$key = array_search($email, array_column($array_users, 'email'));

			if ($key){
				$result = "Пользователь с указанным вами Email уже существует.";
				Logger::write_log("registration.log", "Пользователь с Email уже существует. Email: ".$email);
			} else{
				$result = "Регистрация пройдена успешно!";
				Logger::write_log("registration.log", "Регистрация пройдена успешно! Email: ".$email);
			}

		} else {
			$result = $error;	// возвращаем на фронт массив полей, где есть ошибки
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
?>