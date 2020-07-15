const form = document.querySelector('.main-form');

form.addEventListener('submit', e => {
	e.preventDefault();
	let data = $('.main-form').serialize();

	$.ajax({
		url: 'php/requsts/login.php',
		type: 'POST',
		data: data,
		success: e => {
			let res = JSON.parse(e);

			console.log(e)
			if(res.type == 'error'){
				$('.error').html(res.message);
			}else{
				window.location = res.message;
			}
		}
	})
} )