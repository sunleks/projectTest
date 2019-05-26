<?php 
	$d = date('Y');


	$db = new PDO('mysql:host=localhost;dbname=parshin', 'root', '');
	$db->exec('SET NAMES UTF-8');
	
	$query = $db->prepare('SELECT * FROM cities');
	$query->execute();
	$cities = $query->fetchAll();

	echo '<pre>';
	print_r($cities);
	echo '</pre>';







	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$dt = date("Y-m0d H:i:s");
		$name = $_POST['name'];
		$age = $_POST['age'];
		$city = $_POST['city'];
		$result = $_POST['list'];
		


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
			file_put_contents('data.txt', "$dt $name $age $city $result\n", FILE_APPEND);
			$msg = 'отправка успешно завершена';
		}

	} 

	else {
		$name = '';
		$age = '';
		
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
		<label for="name">Имя</label>
		<input type="text" name="name" id="name" value="<?php echo $name;?>">
		<label for="age">Возраст</label>
		<input type="text" name="age" id="age" value="<?php echo $age;?>">
		<label for="city">Город</label>
		<input type="text" name="city" id="city" value="<?php echo $cities['2'];?>">
		<select name="cities" id="cities">
			<?php foreach ($cities as $key => $cities) { ?>
				
			<option name="list"><?php  echo $cities[cities]?></option>
			
			<?php } ?>
		</select>
		<input type="submit" name="submit" value="submit" id="submit">
	</form>
	<div>
		<?php echo $msg ?>
	</div>
	<?php echo $_POST['Имя']; ?>
	<p>&copy; 2019 - <?php echo $d ?></p>
</body>
</html>
