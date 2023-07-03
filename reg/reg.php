<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../css/style_auth.css">
		<meta charset="utf-8">
		<title>Регистрация</title>
		<script defer src="../js/jquery-3.6.4.min.js"></script>
		<script defer src="../js/ajax.js"></script>
	</head>
	<body>
		<div class = 'reg'>
			<form id="reg">
				<h3>Регистрация</h3>
				<label for="surname">Фамилия:</label>
	            <input id="surname" type="text" name="f[surname]" required />

	            <label for="name">Имя:</label>
	            <input id="name" type="text" name="f[name]" required />

	            <label for="email">Email:</label>
	            <input id="email" type="email" name="f[email]" required />

	            <label for="login">Логин:</label>
	            <input id="login" type="text" name="f[login]" required />

	            <label for="pass">Пароль:</label>
	            <input id="pass" minlength="6" type="password" name="f[pass]" required />
	            
	            <button id="btn-reg" type="button" onclick="location.href='../auth/auth.php'">Войти</button>
	            <button type="submit" value="Save">Зарегестрироваться</button>
	        </form>

	        <div id="my_message"></div>
	    </div>
	</body>
</html>