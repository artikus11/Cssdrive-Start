jQuery.extend(jQuery.fn, {
	/*
	 * функция проверки, что длина поля не меньше 3х символов
	 */
	checka: function () {
		if (jQuery(this).val().length < 3) {jQuery(this).addClass('error');return false} else {jQuery(this).removeClass('error');return true}
	},
	/*
	 * функция проверки правильности введенного email
	 */
	checke: function () {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var emailaddressVal = jQuery(this).val();
		if (!emailReg.test(emailaddressVal) || emailaddressVal == "") {
			jQuery(this).addClass('error');return false
		} else {
			jQuery(this).removeClass('error');return true
		}
	},
});

jQuery(function($){
	$('#commentform').submit(function(){
		// может такое случиться, что пользователь залогинен - нужно это проверить, иначе валидация не пройдет
		if($("#author").length) var author = $("#author").checka();
		if($("#email").length) var email = $("#email").checke();
		var comment = $("#comment").checka();
		// небольшое условие для того, чтобы исключить двойные нажатия на кнопку отправки
		// в это условие также входит валидация полей
		if (!$('#submit').hasClass('loadingform') && !$("#author").hasClass('error') && !$("#email").hasClass('error') && !$("#comment").hasClass('error')){
			$.ajax({
				type : 'POST',
				url : 'http://' + location.host + '/wp-admin/admin-ajax.php',
				data: $(this).serialize() + '&action=ajaxcomments',
				beforeSend: function(xhr){
					// действие при отправке формы, сразу после нажатия на кнопку #submit
					$('#submit').addClass('loadingform').val('Загрузка');
				},
				error: function (request, status, error) {
					if(status==500){
						alert('Ошибка при добавлении комментария');
					} else if(status=='timeout'){
						alert('Ошибка: Сервер не отвечает, попробуй ещё.');
					} else {
						// ворпдрессовские ошибочки, не уверен, что это самый оптимальный вариант
						// если знаете способ получше - поделитесь
						var errormsg = request.responseText;
						var string1 = errormsg.split("<p>");
						var string2 = string1[1].split("</p>");
						alert(string2[0]);
					}
				},
				success: function (newComment) {
					// Если уже есть какие-то комментарии
					if($('.commentlist').length > 0){
						// Если текущий комментарий является ответом
						if($('#respond').parent().hasClass('comment')){
							// Если уже есть какие-то ответы
							if($('#respond').parent().children('.children').length){
								$('#respond').parent().children('.children').append(newComment);
							} else {
								// Если нет, то добавляем  <ul class="children">
								newComment = '<ul class="uk-list">'+newComment+'</ul>';
								$('#respond').parent().append(newComment);
							}
							// закрываем форму ответа
							$("#cancel-comment-reply-link").trigger("click");
						} else {
							// обычный коммент
							$('.commentlist').append(newComment);
						}
					}else{
						// если комментов пока ещё нет, тогда
						newComment = '<ul class="commentlist">'+newComment+'</ol>';
						$('#respond').before($(newComment));
					}
					// очищаем поле textarea
					$('#comment').val('');
				},
				complete: function(){
					// действие, после того, как комментарий был добавлен
					$('#submit').removeClass('loadingform').val('Отправить');
				}
			});
		}
		return false;
	});
});
