/**
    Envia una petición ajax al servidor
    @param {string} url Url del servidor
    @param {string} method Tipo de request (get, post)
    @param {array} params Lista de parametros
    @param {function} success funcion a ejecutarse en caso de exito
    @param {function} failed función a ejecutarse en caso de error
    @param {bool} async (optional) bandera asincrona
    @param {bool} background (optional) la funcion que llama a este metodo corre como background
*/
function sendRequest (url, method, params,  success, failed, async, background) {
    console.log(method);
    if (async == null){
       async = true;
    }
    if (background == null){
       background = false;
    }
    $.ajax({
       url: url,
       method: method,
       data: params,
       async: async,
       dataType: 'json',
       timeout: 25000,
       success:  function (response, status, xhr) {
          if (typeof(success) == 'function') {
             success(response);
          }
       },
       error: function (xhr, status) {
          console.log(xhr);
          switch (status) {
             case 401:
                alert("No tiene los permisos necesarios");
             break;
             case 426:
                alert("Se requiere una actualización de su aplicación");
             break;
             case 404:
                alert("El recurso solicitado no existe");
             break;
             case 402:
                alert("Se requiere una subscripción activa");
             break;
             case 500:
                alert("El servidor presentó un error, intentelo de nuevo más tarde");
             break;
             case 0:
                alert("Verifique su conexión a Internet");
             break;
             default:
                alert("Ocurrió un error inesperado");
             break;
          }
          if (background === true) {
             if (typeof(failed) == 'function') {
                failed(error);
             }
          }
       }
    });
 }
