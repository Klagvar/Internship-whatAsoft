<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../css/style_auth.css">
		<meta charset="utf-8">
		<title>Авторизация</title>
		<script defer src="../js/jquery-3.6.4.min.js"></script>
		<script defer src="../js/ajax.js"></script>
	</head>
	<body>
		<?php if(isset($_SESSION['user'])) { 
			$new_url = '../index.php';
            header('Location: '.$new_url);
		 } else { ?>
			<h2>Авторизация</h2>
			<form id="auth">
	            <label for="login">Login:</label>
	            <input id="login" type="text" name="f[login]" required />

	            <label for="pass">Password:</label>
	            <input id="pass" minlength="6" type="password" name="f[pass]" required />

	    		<button id="btn-reg" type ="button" onclick="location.href='../reg/reg.php'">Зарегистрироваться</button>
	    		<button id="btn-auth" type="submit" value="Save">Войти</button>
	        </form>

	        <div id="my_message"></div>
        <?php } ?>
	</body>
</html>