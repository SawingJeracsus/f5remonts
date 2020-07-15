const form = document.querySelector('.main-form');
form.addEventListener('submit', (e) => {
	e.preventDefault();
	let data = $('.main-form').serialize();
	$.ajax({
		url: 'php/requsts/register.php',
		data: data,
		type: 'POST',
		success: (e) => {
			// console.log(e)
			let res = JSON.parse(e);

			if(res.type == 'error'){
				$('.error').html(res.message);
			}else{
				window.location = res.message;
			}
		}
	})
})