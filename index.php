<?php 
	$db = [
		'host' => 'localhost',
		'root' => 'root',
		'password' => '',
		'name' => 'parshin'
	];

	$link  = mysqli_connect($db['host'], $db['root'], $db['password'], $db['name']);
	$sql = "SELECT * FROM users u INNER JOIN cities c ON u.id_country = c.id";
	$result = mysqli_query($link, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$resultCities = mysqli_query($link, "SELECT * FROM cities");
	$cities = mysqli_fetch_all($resultCities, MYSQLI_ASSOC);

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$name = $_POST['name'];
		$age = $_POST['age'];
		$city = $_POST['cities'];	

		if ($name == "" || $age == "") {
			 $msg = 'Пожайлуйста введите корректные данные';
		} 
		else if (!ctype_digit($age)) {
			$msg = 'Внимательно проверьте правильность написания данных в поле Возраст';
		}

		else if ($age <= 10 || $age >= 100) {
				$msg = 'Ваш возраст должен быть от 10 до 100.';
			}  

		else {
			$sql1 = "INSERT INTO users (name, age, id_country) VALUES ('$name', '$age', '$city')";
			if (mysqli_query($link, $sql1)) {
      			echo "Отправка успешно завершена";
			} else {
      			echo "Ошибка: " . $sql1 . "<br>" . mysqli_error($link);
			}
			mysqli_close($link);
			$msg = 'отправка успешно завершена';
		}

	} 
	else {
		$msg = 'введите данные';
	};
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>testProject</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<style>
		form {
			width: 400px;
			display: flex;
			flex-wrap: wrap;
			margin-top: 50px;
		}

		input {
			width: 100%;
			margin-bottom: 20px;
		}
		.table {
			width: 400px;
			display: flex;
			justify-content: space-between;
		}
		.table__colum {
			width: 33%;
		}
		.table__cell--header {
			font-weight: 700;
		}
		select {
			margin-left: auto;
			width: 80%;
		}
	</style>	
	<div class="table">
		<div class="table__column">
			<div class="table__cell table__cell--header">Имя</div>
			<?php foreach ($users as $key => $value):?>
			<div><?=$value['name']?></div>
			<?php endforeach; ?>
		</div>
		<div class="table__column">
			<div class="table__cell table__cell--header">Возраст</div>
			<?php foreach ($users as $key => $value):?>
			<div><?=$value['age']?></div>
			<?php endforeach; ?>
		</div>
		<div class="table__column">
			<div class="table__cell table__cell--header">Город</div>
			<?php foreach ($users as $key => $value):?>
			<div><?=$value['cities']?></div>
			<?php endforeach; ?>
		</div>
		
	</div>
	<form method="post" action="" name="form">
		<label for="name">Имя</label>
		<input type="text" name="name" id="name" value="<?=$name;?>">
		<label for="age">Возраст</label>
		<input type="text" name="age" id="age" value="<?=$age;?>">
		<div>Город</div>
		<br>
		<select name="cities" id="cities">
			<?php foreach ($cities as $key => $cities) { ?>
			<option value="<?=$cities['id']?>"><?=$cities['cities']?></option>
			<?php } ?>
		</select>
		<input type="submit" name="submit" value="submit" id="submit">
	</form>
	<div>
		<h1><?=$msg ?></h1>
	</div>
</body>
</html>
