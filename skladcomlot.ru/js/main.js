// Отправка заявки 
$(document).ready(function() {
	$('#form').submit(function() { // проверка на пустоту заполненных полей. Атрибут html5 — required не подходит (не поддерживается Safari)
		if (document.form.name.value == '' || document.form.phone.value == '' || document.form.email.value == '' || document.form.text.value == '' ) {
			valid = false;
			return valid;
		}
		$.ajax({
			type: "POST",
			url: "mail.php",
			data: $(this).serialize()
		}).done(function() {
			$('.modal_thanks').fadeIn();
			$(this).find('input').val('');
			$('#form').trigger('reset');
		});
		return false;
	});
});

// Закрыть попап «спасибо»
$('.close-popup').click(function() { // по клику на крестик
	$('.modal_thanks').fadeOut();
});

$(document).mouseup(function (e) { // по клику вне попапа
    var popup = $('.popup');
    if (e.target!=popup[0]&&popup.has(e.target).length === 0){
        $('.modal_thanks').fadeOut();
    }
});

// Маска ввода номера телефона (плагин maskedinput)
$(function($){
	$('[name="phone"]').mask("+7(999) 999-99-99");
});

