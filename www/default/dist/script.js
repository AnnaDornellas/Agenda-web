var onloadCallback = function () {

    var googleKeyrecaptcha = '6Leo_TAiAAAAAMNJ_CaVWTNtUjwOtoXePzEjtA1D';

    if (document.getElementById('recaptchaLogin') != null) {
        recaptchaLogin = grecaptcha.render('recaptchaLogin', {
            'sitekey': googleKeyrecaptcha,
            'theme': 'light',
            'callback': onSubmitLogin
        });
    }
}


function onload() {
    if (document.getElementById('submitLogin') != null) {
        var elementLogin = document.getElementById('submitLogin');
        elementLogin.onclick = validateLogin;
    }
}

function validateLogin(event) {
    event.preventDefault();

    var $username = $('#floatingLoginUsername');
    var $password = $('#floatingLoginPassword');
    var $error = true;

    if (!userName($username.val())) {
        $error = false;
        $username.addClass('is-invalid');
    } else {
        ($error === false) ? $error = false : $error = true;
        $username.removeClass('is-invalid');
    }

    if ($password.val() == '') {
        $error = false;
        $password.addClass('is-invalid');
    } else {
        ($error === false) ? $error = false : $error = true;
        $password.removeClass('is-invalid');
    }

    if ($error) {
        grecaptcha.execute(recaptchaLogin);
    }
}

function onSubmitLogin(recaptcha) {

    $('.btn-request-login').removeClass('d-none');
    var $recaptcha = recaptcha;
    var $username = $('#floatingLoginUsername');
    var $password = $('#floatingLoginPassword');
    var $url = $('#formLogin').attr("action");
    var $dashboard = $('#dashboard');

    $.ajax({
        method: "POST",
        url: $url,
        dataType: 'json',
        data: "username=" + $username.val() + "&password=" + $password.val() + "&recaptcha=" + $recaptcha
    }).fail(function (result) {
        console.log("onSubmitLogin: Não foi possível realizar a requisição!");
        return false;
    }).done(function (result) {

        $('.btn-request-login').addClass('d-none');

        $username.removeClass('is-invalid');
        $password.removeClass('is-invalid');

        if (result.error) {
            alert(result.message_error);
        } else {
            window.location.href = $dashboard.val();
        }
        grecaptcha.reset(recaptchaLogin);
    });


}

function userName($name) {
    var filter = /^[a-zA-Z0-9]+$/;
    if (filter.test($name)) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function () {
    onload();
});