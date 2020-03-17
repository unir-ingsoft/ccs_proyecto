/**
    Valida un nombre de usuario y contraseña
    @returns {void} 
    @var username {string} nombre de usuario obtenido por jQuery del formulario
    @var password {string} contraseña obtenida por jQuery del formulario
    @var parametros {array} el arreglo de parametros que ajax enviará al servidor
*/
$("#login").on('click', function(){
    let username =  $("#email").val(),
        password = $("#pass").val(),
        parametros = {},
        url = uris['url'+environment];
    console.log(username);
    console.log(password);
    try
	{
		if(username != '' && password != ''){
			parametros = {
                username: username,
                password: password,
                action: 'login'
            };
			sendRequest(url + 'index.php', 'POST', parametros, 
		        function (data) {
                    console.log(data);
                    console.log(typeof(data));
                    let objdata = JSON.parse(data);
                    console.log(objdata.cNombre);
                    console.log(typeof(objdata));
                    if(data.length > 0){
                        sessionStorage.setItem("sessionStarted", 1);
                        sessionStorage.setItem("nombre", data.cNombre);
                        window.location="alta_programa.html";
                    }
                    else {
                        alert("Sus credenciales no son correctas");
                    }
                },
                function (data) {
                    alert("Un error indesperado ha ocurrido");
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