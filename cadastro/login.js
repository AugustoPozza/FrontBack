function doLogin() {
    let usuario = $('#usuario').val();
    let senha = $('#senha').val();
    let dados = {
        usu: usuario,
        sen: senha
    }
    $.ajax({
        url: 'validaLogin.php',
        type: 'POST',
        data: dados,
        success: function (response) {
            $('#msg').html(response);
            /*
            let json = JSON.parse(response);
            let msg = json.msg;
            if (json.status == 1) {
                msg += " " + json.token;
            }
            $('#msg').html(msg);
            */
        }
    });
}