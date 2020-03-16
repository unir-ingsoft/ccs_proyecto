/**
    Valida un nombre de usuario y contraseña
    @returns {void} 
    @var username {string} nombre de usuario obtenido por jQuery del formulario
    @var password {string} contraseña obtenida por jQuery del formulario
    @var parametros {array} el arreglo de parametros que ajax enviará al servidor
*/
$("#login").on('click', function(){
    let username =  $("#name").val(),
        password = $("#pass").val(),
        parametros = {},
        url = uris['url'+environment];
    try
	{
		if(username != '' && password != ''){
			parametros = {
                username: username,
                password: password
            };
			sendRequest(url + 'user/login', 'POST', parametros, 
		        function (data) {
                    if(data.message != "401"){
                        sessionStorage.setItem("sessionStarted", 1);
                        window.location="panel.html";
                    }
                    else {
                        alert("Sus credenciales no son correctas");
                    }
                },
                function (data) {
                    alert("Sus credenciales no son correctas");
                }
		   );
		}
		else {
			if(username === '')
			{
				alert("Ingrese su nombre de usuario");
			}
			else if(password === ''){
				alert("Ingrese su contraseña");
			}
		}
	}
	catch(err)
	{
		console.log(err);
		alert("Error inesperado");
    }
});