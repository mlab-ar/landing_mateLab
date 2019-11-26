$("#contact").submit(function(e) {
    e.preventDefault();

    var form = $(this);

    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.respuestaAjax');

    var msjError = "Ocurrió un error inesperado Por favor recargue la página";
    var formdata = new FormData(this);
    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    if (percentComplete < 100) {
                        respuesta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: ' + percentComplete + '%;"></div></div>');
                    } else {
                        respuesta.html('<p class="text-center"></p>');
                    }
                }
            }, false);
            return xhr;
        },
        success: function(data) {
            if (data.error !== undefined) {
                respuesta.html(data.error);
            }
            else{
                respuesta.html(data.success);
                $('#contact').trigger('reset');
            }
        },
        error: function() {
            respuesta.html(msjError);
        }
    });
    return false;
});