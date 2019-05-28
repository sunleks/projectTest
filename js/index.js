var select = document.querySelector('select');
var city = document.querySelector('#city');

	select.addEventListener('change', function () {
		console.log('1123');
		var selectName = select.options[select.selectedIndex].value;
		city.value = selectName;
	});

