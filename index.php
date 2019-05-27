<?php 
	$d = date('Y');

	// Подключение к БД
	$db = new PDO('mysql:host=localhost;dbname=parshin', 'root', '');
	$db->exec('SET NAMES UTF-8');
	
	$query = $db->prepare('SELECT * FROM cities');
	$query->execute();
	$cities = $query->fetchAll();


	//Распечатка всей БД на странице
	echo '<pre>';
	print_r($cities);
	echo '</pre>';


	// Проверка на правильность ввода данных. Отправка данных осуществляется методом POST
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$dt = date("Y-m0d H:i:s");
		//Считываем значения полей input и сохраняем в переменные
		$name = $_POST['name'];
		$age = $_POST['age'];
		$city = $_POST['city'];
		$result = $_POST['list'];
		

		//Проверка на заполненность полей
		if ($name == "" || $age == "" || $city == "") {
			 $msg = 'Пожайлуйста введите корректные данные';
		} 
		else if (!ctype_digit($age)) {
			$msg = 'Внимательно проверьте правильность написания данных в поле Возраст';
		}

		else if ($age <= 10 || $age >= 100) {
				$msg = 'Ваш возраст должен быть от 10 до 100.';
			}  

		else {
			//Если всё верно заполненно, то мы создаём файл в котором хранятся наши данные и выводим сообщение, что отправка завершена
			file_put_contents('data.txt', "$dt $name $age $city $result\n", FILE_APPEND);
			$msg = 'отправка успешно завершена';
		}

	} 

	else {
		// На некотрых хостингах мы можем столкнуться с проблемой, что в форме input может написано быть непонятные вещи. Таким образом при переназначении этих переменных  с пустыми строками мы перестраховываемся от этого недоразумения
		$name = '';
		$age = '';
		
		//Когда только загружается сайт мы выводим сообщение о том, что надо ввести данные
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
	<div>Имя: 
		<?php
			echo $_POST['name'];
		?>
	</div>
	<div>Возраст:
		<?php
			echo $_POST['age'];
		?>
	</div>
	<div>Город: 
		<?php
			echo $_POST['value'];
		?>
	</div>
	<form method="post">
		<!-- В значение value мы передаём наши переменные, в которых мы сохранили данные ввода  -->
		<label for="name">Имя</label>
		<input type="text" name="name" id="name" value="<?php echo $name;?>">
		<label for="age">Возраст</label>
		<input type="text" name="age" id="age" value="<?php echo $age;?>">
		<label for="city">Город</label>
		<input type="text" class="city" name="city" id="city" value="<?php echo $city;?>">
		<select name="cities" id="cities">
			<!-- Проходим циклом foreach по двумерному массиву и выводим значение cities -->
			<?php foreach ($cities as $key => $cities) { ?>
				
			<option value="<?=$cities['cities']?>"><?=$cities['cities']?></option>
			
			<?php } ?>
		</select>
		<input type="submit" name="submit" value="submit" id="submit">
	</form>

	<div>
		<!-- Выводим ошибку заполнения полей -->
		<h1><?=$msg ?></h1>
	</div>
	<p>&copy; 2019 - <?=$d ?></p>
	<script src="js/index.js"></script>
</body>
</html>
