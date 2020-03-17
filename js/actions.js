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
                    if(data.length > 0){
                        sessionStorage.setItem("sessionStarted", 1);
                        sessionStorage.setItem("nombre", data[0].cNombre);
                        sessionStorage.setItem("userpk", data[0].nUsuarioPK);
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

$("#btn_registrarPrograma").on('click', function(){
    let tema =  $("#tema").val(),
        urlShow = $("#urlShow").val(),
        fecha = $("#fecha").val(),
        hora = $("#hora").val(),
        usuariopk = $("#usuariopk").val(),
        parametros = {},
        url = uris['url'+environment];

    try
    {
        parametros = {
            tema: tema,
            urlShow: urlShow,
            fecha: fecha,
            hora : hora,
            usuariopk: usuariopk,
            action: 'crearShow'
        };
        sendRequest(url + 'index.php', 'POST', parametros, 
            function (data) {
                if(data > 0 || data != "0"){
                    alert("Programa guardado con exito")
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
    catch(err)
    {
        console.log(err);
        alert("Error inesperado");
        }
});

function updatePrograma(programapk){
    let tema =  $("#ntema"+programapk).val(),
        urlShow = $("#nurl"+programapk).val(),
        fecha = $("#nfecha"+programapk).val(),
        hora = $("#nhora"+programapk).val()
        parametros = {},
        url = uris['url'+environment];
    try
    {
        parametros = {
            tema: tema,
            urlShow: urlShow,
            fecha: fecha,
            hora : hora,
            programapk: programapk,
            action: 'editarPrograma'
        };
        sendRequest(url + 'index.php', 'POST', parametros, 
            function (data) {
                if(data > 0 || data != "0"){
                    alert("Programa editado con exito");
                    location.reload();
                }
                else {
                    alert("No se pudo editar el programa");
                }
            },
            function (data) {
                alert("Un error indesperado ha ocurrido");
            }
        );
    }
    catch(err)
    {
        console.log(err);
        alert("Error inesperado");
    }
}

function cargarProgramas(){
    try
     {
       parametros = {
          action: 'obtenerProgramas'
       };
       sendRequest(url + 'index.php', 'POST', parametros, 
          function (data) {
             console.log(data);
             console.log(typeof(data));
             if(data.length > 0){
                $("#programas").html('');
                for(var i=0; i<data.length; i++){
                   let html = 
                      '<li>'+
                         '<img width="100" height="100" src="app/css/img/logo.jpg" />'+
                         '<h3>'+$data[i].cTema+'</h3> <a href="'+data[i].cUrl+'" target="_blank" style="float:right !important" ><img src="app/css/img/radio.png"></a>'+
                         '<p>Host: '+data[i].cNombre+' '+data[i].cApellido+'</p>'+
                         '+<p>¿Cuándo?: '+data[i].dFecha+' a las '+data[i].cHora+'<p>'+
                         '<p>';
                         if(sessionStorage.getItem('userpk') == data[i].nUsuarioPK){
                            html += '<img onclick="showUpdate('+data[i].nProgramaPK+')" src="app/css/img/edit.png">'+
                                  '<a href="#" onclick="borrarPrograma('+data[i].nProgramaPK+')"><img src="app/css/img/delete.png"></a>';
                         }
                      html +=
                         '</p>'+
                         '<div id="'+data[i].nProgramaPK +'" style="display:none">'+
                            '<div class="login-form validate-form">'+
                                  '<div class="wrapper-inputs validate-input" data-validate = "Este campo es obligatorio">'+
                                     '<input class="input" type="text" maxlength="150" name="tema" id="ntema'+data[i].nProgramaPK+'" placeholder="Tema del programa" value="'+data[i].cTema+'" required>'+
                                  '</div>'+
                                  '<div class="wrapper-inputs validate-input" data-validate = "Este campo es obligatorio">'+
                                     '<input class="input" type="url" maxlength="150" name="url" id="nurl'+data[i].nProgramaPK+'" placeholder="Url al programa" value='+data[i].curl+'" required>'+
                                  '</div>'+
                                  '<div class="wrapper-inputs validate-input" data-validate = "La fecha es obligatoria">'+
                                     '<input class="input" type="date" name="fecha" id="nfecha'+data[i].nProgramaPK+'" placeholder="Fecha" required value="'+data[i].dFecha+'">'+
                                  '</div>'+
                                  '<div class="wrapper-inputs validate-input" data-validate = "El horario es obligatorio">'+
                                     '<input class="input" type="time" name="hora" id="nhora'+data[i].nProgramaPK+'" placeholder="Hora" required value="'+data[i].cHora+'">'+
                                  '</div>'+
                                  '<div class="container-login-btn">'+
                                     '<button class="login-btn" onclick="editarPrograma('+data[i].nProgramaPK+')">'+
                                        'Guardar'+
                                     '</button>'+
                                     '<div class="text-center" onclick="hideUpdate('+data[i].nProgramaPK+')">'+
                                        'Cancelar'+
                                     '</div>'+
                                  '</div>'+
                            '</div>'+
                         '</div>'+
                      '</li>';
                   $("#programas").append(html);
                }
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
     catch(err)
     {
         console.log(err);
         alert("Error inesperado");
    }
 }
 
function borrarPrograma(id){
    try
    {
        parametros = {
          programapk: id,
          action: 'eliminarPrograma'
        };
        sendRequest(url + 'index.php', 'POST', parametros, 
            function (data) {
                if(data > 0 || data != "0"){
                    alert("Programa eliminado con exito");
                    location.reload();
                }
                else {
                    alert("No se pudo eliminar el programa");
                }
            },
            function (data) {
                alert("Un error indesperado ha ocurrido");
            }
        );
    }
    catch(err) {
       console.log(err);
         alert("Error inesperado");
    }
 }

$("#logout").on('click', function(){
    sessionStorage.clear();
    window.location="alta_programa.html";
})