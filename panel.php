<?php
if(isset($_POST['logout'])) {
    $dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
	unset($_COOKIE['id']);
	unset($_COOKIE['email']);
	setcookie('id', null, -1, '/');
	setcookie('email', null, -1, '/');
	header('Location: index.php');
};

if(isset($_POST['del'])) {
	$dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
	$id = mysqli_real_escape_string($dbc, trim($_POST['ide']));
	$query ="DELETE FROM users WHERE id = '$id'";
	$result = mysqli_query($dbc, $query);
	header('Location: panel.php');
	mysqli_close($dbc);
	exit();
}

if(isset($_COOKIE['id'])) {
	$dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
$id = $_COOKIE['id'];
$query ="SELECT image FROM users WHERE id = '$id'";
$result = mysqli_query($dbc, $query);
$data = mysqli_fetch_row($result);
$image_name=$data[0];
$image_path="images";
}

?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Панель администратора </title>
	<link rel="stylesheet" type="text/css" href="styles/panel.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<style>
	.wrapper {
		display: grid;
		grid-template-columns: auto 1000px auto;
		grid-template-areas: 
			"b a ."
	}
	.panel1 {
		grid-area: a;
		align-self: center;
		justify-self: center;
	}
</style>

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
	<p><button onclick="location.href = 'index.php'" class="button" style="width: 100%; height: 35px; margin: 10px 0 0 0;">На главную</button></p>
	</div>

<?php   
	}
	else
	{
?>
<div class="wrapper">
	<div class="panel1 panel">
	<h1>Пользователи:</h1>
	<table id="notes" class="notes">
	<thead>
	<tr><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Уровень доступа</th><th>Действие</th><th style='display: none;'>=</th></tr>
	</thead>
	<tbody>
	<?php
		$dbc = mysqli_connect('localhost', 'u0566924_ds', 'Gfhjkm111222', 'u0566924_nanobouquetds');
		$mail = $_COOKIE['email'];
		$query ="SELECT * FROM users";
		$result = mysqli_query($dbc, $query);
		$rows = mysqli_num_rows($result);
		for ($i = 0 ; $i < $rows ; ++$i) {
			$row = mysqli_fetch_row($result);
			echo "<tr>";
			if ($j = 1) echo "<td>$row[$j]</td>";
			if ($j = 2) echo "<td>$row[$j]</td>";
			if ($j = 3) echo "<td>$row[$j]</td>";
			if ($j = 4) echo "<td>$row[$j]</td>";
			if ($j = 6) echo "<td>$row[$j]</td>";
			if ($j = 100) echo "<td style='width: 321px;'><button id='$i' class='button' onclick='edit($i)'>Редактировать</button> 
									<button name='delete' class='button' onclick='dl($i)'>Удалить</button></td>";
			if ($j = 7) echo "<td style='display: none;'>$row[0]</td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
		mysqli_close($dbc);
	?>
	</tbody>
	</table>
	<p style='margin: 0'>Поиск: <input type="text" id="myInputTextField"></p>

	<div class='buttons'>
	<p class="photo"><?php if(!empty($image_name)) { echo('<img src='.$image_path.'/'.$image_name.' width=40 height=40>'); } ?></p>
	<p><button onclick="location.href = 'create.php'" class="button">Создать новую учетную запись</button></p>

	<form method="POST">
    <p><button type="submit" name="logout" class="button">Выйти</button></p>
	</form>
	</div>

	<form method="POST">
    <input type="hidden" class="kkk" name="ide" id="ide" size="35">
    <button name="del" id='del' style="visibility: hidden;"></button>
    </form>
	</div>
</div>
<?php   
	}
?>

<script type="text/javascript">
    function edit(q){
        var z = document.getElementById('notes').rows[q%10+1].cells[6].innerHTML;
        window.location = "edit.php?id=" + z;
    }

	function dl(z){
        var val = document.getElementById('notes').rows[z%10+1].cells[6].innerHTML;
        document.getElementById('ide').value = val;
        document.getElementById('del').click();
    }

	$(document).ready( function () {
		$('#notes').DataTable({
			"order": [[ 6, "asc" ]],
			"lengthChange":   false,
			dom: 'lrtip'
		});
	} );

	$('#myInputTextField').keyup(function(){
		$('#notes').DataTable().search($(this).val()).draw() ;
	})
</script>
</body>
</html>
