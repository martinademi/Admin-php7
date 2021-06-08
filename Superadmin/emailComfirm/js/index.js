var get_url = window.location.href;
var splitted_url = get_url.split('??');
console.log(splitted_url[1]);
if (splitted_url[1] == undefined) {

	$(".login").empty();
	$(".login").append('<span style="color:#fff;font-size:20px">Link expired</span>');
} else {
	$.ajax({
		url: url + "utility/validateResetLink",
		type: 'GET',
		data: '',
		dataType: 'JSON',
		headers: { 'authorization': splitted_url[1], 'language': 'en' },
		contentType: "application/json",
		success: function (response) {

		},
		error: function (error) {
			console.log('error', error);
			if (error.status == 401) {
				$(".login").empty();
				$(".login").append('<span style="color:#fff;font-size:20px">Link unauthorized</span>');
			} else {
				$(".login").empty();
				$(".login").append('<span style="color:#fff;font-size:20px">Server error</span>');
			}
		}

	});
}


function validatePassword() {
	var password = $("#password").val();
	var confirm_password = $("#confirm_password").val();
	console.log("password.value", password);
	console.log("confirm_password.value", confirm_password);
	if (password != confirm_password) {
		$('.error_msg').text('Passwords Donot Match');
	} else {
		send_password();
	}
}
function send_password() {
	$("#password_hidden").trigger('click');
	$.ajax({
		url: url + "utility/resetPassword",
		type: 'POST',
		headers: { 'authorization': splitted_url[1], 'language': 'en' },
		data: JSON.stringify({
			"password": password.value
		}),
		dataType: 'JSON',
		contentType: "application/json",
		success: function (response) {
			$(".login").empty();
			$(".login").append('<span style="color:#fff;font-size:20px">' + response.message + '</span>');

		}, error: function (error) {
			$(".login").empty();
			$(".login").append('<span style="color:#fff;font-size:20px">' + response.errMsg + '</span>');
		}
	});

}
$("#password,#confirm_password").focus(function () {
	$('.error_msg').empty();
});
$('#submit').click(function (event) {
	event.stopPropagation();
	if (password.value != "") {
		validatePassword();
	} else {
		$('.error_msg').text('Enter password')
	}

});
$("#password_hidden").click(function () {
	$('.login').addClass('test')
	setTimeout(function () {
		$('.login').addClass('testtwo')
	}, 300);
	setTimeout(function () {
		$(".authent").show().animate({ right: -20 }, { easing: 'easeOutQuint', duration: 600, queue: false });
		$(".authent").animate({ opacity: 1 }, { duration: 200, queue: false }).addClass('visible');
	}, 500);
	setTimeout(function () {
		$(".authent").show().animate({ right: 90 }, { easing: 'easeOutQuint', duration: 600, queue: false });
		$(".authent").animate({ opacity: 0 }, { duration: 200, queue: false }).addClass('visible');
		$('.login').removeClass('testtwo')
	}, 2500);
	setTimeout(function () {
		$('.login').removeClass('test')
		$('.login div').fadeOut(123);
	}, 2800);
	setTimeout(function () {
		$('.success').fadeIn();
	}, 3200);
});
$('input[type="text"],input[type="password"]').focus(function () {
	$(this).prev().animate({ 'opacity': '1' }, 200)
});
$('input[type="text"],input[type="password"]').blur(function () {
	$(this).prev().animate({ 'opacity': '.5' }, 200)
});

$('input[type="text"],input[type="password"]').keyup(function () {
	if (!$(this).val() == '') {
		$(this).next().animate({ 'opacity': '1', 'right': '30' }, 200)
	} else {
		$(this).next().animate({ 'opacity': '0', 'right': '20' }, 200)
	}
});

var open = 0;
$('.tab').click(function () {
	$(this).fadeOut(200, function () {
		$(this).parent().animate({ 'left': '0' })
	});
});

console.log(body.background);
$(document).ready(function () {
	$("body").css(body);
	$("body").find("p").css(bodyP);
	$("body .authent").css(bodyAuth);
	$("body .authent p").css(authP);
	$("body .success").css(success);
	$("body p").css(bodyP);
	$("body .login").css(login);
	$("body .login_title").css(login_title);
	$("body .login_fields input[type='password']").css(login_input_pwd);
	$("body .login_fields input[type='text'], body .login_fields input[type='password']").css(login_input_txt_pwd);
	$("body .login_fields__submit .forgot a").css(forgotA);
	$("body .login_fields__submit input").css(submitInput);
	$("body .login_fields__submit input:hover").css(submitHover);
	$(".error_msg").css(error_msg);
});