<?php
if(isset($_POST['submit'])) {
    $dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
    $login = mysqli_real_escape_string($dbc, trim($_POST['login']));
	$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
	if (empty($login)) {
		$info_reg = 'Вы не ввели логин';
	}
	elseif (empty($password)) {
		$info_reg = 'Вы не ввели пароль';
	}

	elseif(!empty($login) && !empty($password)) {
		$query = "SELECT `id` , `email` FROM `users` WHERE email = '$login' AND password = '$password'";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($data);
		if($row['email'] == $login){
		setcookie('id', $row['id'], time() + (60*60*24*30));
		setcookie('email', $row['email'], time() + (60*60*24*30));
		header('Location: panel.php');
		}
		else {
			$info_reg = 'Вы ввели неверные данные';
		}
	}
};
?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Авторизация </title>
	<link rel="stylesheet" href="styles/index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<form method="POST" class="login">
	<h1>Поле входа</h1>
    <p>Введите логин:</p>
    <input type="text" class="inpst" name="login">
    <p>Введите пароль:</p>
    <input type="password" class="inpst" name="password">
    <p><button type="submit" class="submit" name="submit">Войти</button></p>
	<p class="reg"><?php if(!empty($info_reg)){ echo $info_reg; }?></p>
</form>
</body>
</html>
