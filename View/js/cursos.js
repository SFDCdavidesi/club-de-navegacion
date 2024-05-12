var urlws;
function muestraDatosCurso(urlws,idCurso,idCalendario,permitirInscripcion=false) {
urlws=urlws;
    $("#infoModal").modal('show');
    if (permitirInscripcion) {
        $("#inscribirme").show();
    } else {
        $("#inscribirme").hide();
    }
    cursoseleccionado = idCurso;
    calendarioseleccionado=idCalendario;
   // alert("curso seleccionado: " + idCurso + " calendario seleccionado: " + idCalendario);
    $.ajax({
        url: urlws+"?action=get_curso&id=" + idCurso,
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
            let curso = data[0];
            $("#titulo").html(curso.titulo);
            $("#entradilla").html(curso.entradilla);
            $("#descripcion").html(curso.descripcion);
            //obtenemos el nivel requerido
            $.ajax({
                url: urlws+"?action=get_nivel_requerido&id=" + curso.nivel_requerido,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    let nivel = data[0];
                    console.table(nivel);
                    $("#nivel_requerido").html(nivel.nombre);
                }
            });

            $("#lugar").html(curso.ubicacion);
            $("#numero_plazas").html(curso.numero_plazas);
            $("#duracion").html(curso.duracion + " " + curso.unidadDuracion);


            //obtenemos las fotos del curso
            cargarFotos(urlws,'#fotos', idCurso);

        }
    });
}

var cursoseleccionado;
var calendarioseleccionado;

var arrayfotos = [];
var currentIndex = 0;

function cargarFotos(urlws,idcarrusel, idcurso) {
    currentIndex = 0;
    $.ajax({
        url: urlws+"?action=get_fotos_curso&id=" + idcurso,
        type: "GET",
        dataType: "json",

        success: function(data) {
           arrayfotos=[];
            for (let i = 0; i < data.length; i++) {
                arrayfotos.push(data[i].foto);
            }




            // Llamamos a la función inicialmente para mostrar la primera foto
            mostrarSiguienteFoto();

            // Llamamos a la función cada 3 segundos para mostrar la siguiente foto
            if (arrayfotos.length > 1){
                setInterval(mostrarSiguienteFoto, 3000);

            }else if (arrayfotos.length==0) {
                $('#fotos').empty();

            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error al cargar las fotos:", errorThrown);
        }
    });
}
// Función para mostrar la siguiente foto en el div "fotos"
function mostrarSiguienteFoto() {
    $('#fotos').empty(); // Limpiamos el div antes de agregar la nueva foto
    $('#fotos').append('<img src="' + arrayfotos[currentIndex]+
        '" class="img-responsive" style="max-width: 300px; height: auto;">');
    currentIndex = (currentIndex + 1) % arrayfotos.length; // Avanzamos al siguiente índice (circular)
}