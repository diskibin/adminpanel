<?php
if(isset($_POST['submit'])) {
$dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
$confirm = mysqli_real_escape_string($dbc, trim($_POST['confirm']));
$first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
$last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
$upload_image=$_FILES["myimage"]["name"];
$upload_path=$_FILES["myimage"]["tmp_name"];
move_uploaded_file($_FILES["myimage"]["tmp_name"], "images/". $email. "_" .$_FILES["myimage"]["name"]);
if(!empty($_FILES["myimage"]["name"])) {
	$imagepath = $email. "_" .$_FILES["myimage"]["name"];
}
$access = mysqli_real_escape_string($dbc, trim($_POST['access']));
if (empty($_POST['email'])) {
	$info_reg = 'Заполните все поля';
}
elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $email)) {
	$info_reg = 'Неправильно введен адрес электронной почты';
}
elseif (empty($password)) {
	$info_reg = 'Вы не ввели пароль';
}
elseif (empty($confirm)) {
	$info_reg = 'Вы не ввели подтверждение пароля';
}
elseif ($password != $confirm){
	$info_reg = 'Подтверждение пароля не совпадает с паролем';
}
elseif (empty($first_name)){
	$info_reg = 'Вы не ввели имя';;
}
elseif (empty($last_name)){
	$info_reg = 'Вы не ввели фамилию';
}
elseif (empty($access)){
	$info_reg = 'Вы не ввели уровень доступа';
}
else {
	$query = "INSERT INTO `users` (email, password, first_name, last_name, access, image) VALUES ('$email', '$confirm', '$first_name', '$last_name', '$access', '$imagepath')";
	mysqli_query($dbc, $query);
	header('Location: panel.php');
	mysqli_close($dbc);
	exit();	
}
}
?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Добавить пользователя </title>
	<link rel="stylesheet" type="text/css" href="styles/create.css">
</head>
<body>
<?php   
	$dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
	$email = $_COOKIE['email'];
	$id = $_COOKIE['id'];
	$usl = "SELECT email FROM users WHERE access = 'Администратор'";
	$res = mysqli_query($dbc, $usl);
	$u = mysqli_fetch_row($res);
	if($email != $u[0]){
?>
	<div class="nopanel">
	<p>Вам запрещен просмотр данной страницы</p>
	<p><button onclick="location.href = 'index.php'" class="submit">На главную</button></p>
	</div>

<?php   
	}
	else
	{
?>
	<div class="panel">
	<h1>Создание новой учетной записи</h1>
	<div>
	<form method="POST" enctype="multipart/form-data">
    <p>Введите почту:</p>
    <input type="text" class="inpst" name="email">
    <p>Введите пароль:</p>
    <input type="password" class="inpst" name="password">
	<p>Подтвердите пароль:</p>
    <input type="password" class="inpst" name="confirm">
	<p>Введите имя:</p>
    <input type="text" class="inpst" name="first_name">
	<p>Введите фамилию:</p>
    <input type="text" class="inpst" name="last_name">
	<p>Выберите фото:</p>
	<input type="file" name="myimage">
	<p>Выберите уровень доступа:</p>
	<select id="acc">
  	<option value="Пользователь">Пользователь</option>
  	<option value="Администратор">Администратор</option>
	</select>
	<input type="text" name="access" id="access" style='visibility: hidden;' value="">
    <p><button type="submit" id="submit" class="submit" name="submit" onclick='getValue()'>Добавить</button></p>
	</form>
	</div>

    <p><button onclick="location.href = 'panel.php'" class="submit">Перейти в главную панель</button></p>
	<p class="reg"><?php if(!empty($info_reg)){ echo $info_reg; }?></p>
	</div">
<?php   
	}
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" >
	function getValue() {
		document.getElementById("access").value = document.getElementById("acc").value;
	}

	</script> 

</body>
</html>
