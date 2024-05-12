<?php
include_once 'header.php';
//obtenemos el token si este se ha generado
if (isset($_SESSION) && isset($_SESSION["token"])) {
    $token = $_SESSION["token"];
} else {
    $token ="";
}
?>
<link type="text/css" rel="stylesheet" href="../View/pluggins/calendar-gc.css" />
<script src="../View/pluggins/calendar-gc.js"></script>




<div id="calendario" class="container">
    <div class="row">
        <div class="col-12">
            <h1>Calendario</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="calendar"></div>
        </div>
    </div>
    <?php
    if (isset ($_SESSION) && isset($_SESSION['rol']) && $_SESSION['rol'] == "admin") {
    ?>
    <div class="row">
        <div class="col-12 text-center">
            <a href="./?action=alta_actividades" class="btn btn-primary">Dar de alta actividades</a>
        </div>
    </div>
    <?php
    }
    ?>




</div>


<?php
include_once 'modal_curso.php';
?>
<script>
var calendar = $("#calendar").calendarGC({
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
        'Octubre', 'Noviembre', 'Diciembre'
    ],
    dayBegin: 1,
    date: new Date(),
    onclickDate: function(e, data) {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModalFullscreenXxl'), {
            keyboard: false
        })
        myModal.show();
        console.log(e, data);

    }


});
let hoy = new Date();
let anio = hoy.getFullYear();
let mes = hoy.getMonth();
mes++;
if (mes < 10) {
    mes = "0" + mes;
}
let dia = hoy.getDate();
if (dia < 10) {
    dia = "0" + dia;
}
let diaHoy = anio + "-" + mes + "-" + dia;
//calendar.setDate(anio + "-" + mes+ "-" + dia);
var mesActual;

$(document).ready(function() {
    $("#detalleCursoContenido").hide();
    if (mesActual == undefined) {
        mesActual = new Date().getMonth();
    }
    //obtenemos los calendarios del mes actual
    calendar.setDate(diaHoy);

<?php
if (isset($_SESSION) && isset($_SESSION["rol"])) { ?>
$("#inscribirme").click(function(){
    console.log("inscribirme en el curso "+cursoseleccionado);
    console.log("calendario seleccionado "+calendarioseleccionado);
let confirmacioncurso=document.createElement("div");
confirmacioncurso.innerHTML="Va a proceder a inscribirse en el curso seleccionado. ¿Está seguro de que desea continuar?<br><br>";
let botonconfirmacion=document.createElement("button");
botonconfirmacion.innerHTML="Sí";
botonconfirmacion.classList.add("btn");
botonconfirmacion.classList.add("btn-primary");
confirmacioncurso.appendChild(botonconfirmacion);
let space = document.createTextNode(" ");
confirmacioncurso.appendChild(space);
let botoncancelar=document.createElement("button");
botoncancelar.innerHTML="Cancelar";
botoncancelar.classList.add("btn");
botoncancelar.classList.add("btn-secondary");
confirmacioncurso.appendChild(botoncancelar);
confirmacioncurso.classList.add("alert");
confirmacioncurso.classList.add("alert-warning");
confirmacioncurso.classList.add("mt-3");
confirmacioncurso.classList.add("text-center");
$("#infoModal .modal-body").append(confirmacioncurso);
//si pulsa en el botón Cancelar , cerramos la ventana de confirmación
botoncancelar.addEventListener("click",function(){
    $("#infoModal .modal-body .alert").remove();
});
//si pulsa en el botón Sí, procedemos a inscribir al usuario en el curso
botonconfirmacion.addEventListener("click",function(){
    $.ajax({
        url: "<?=$urlws?>?action=inscribir&idCalendario="+calendarioseleccionado + "&token=<?=$token?>",
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
            if (data.id > 0) {
                alert("Inscripción realizada correctamente");
                window.location.href = "./";
            } else {
                if (data.mensaje != undefined){
                    alert(data.mensaje);
                    //mostrar el mensaje en una ventana modal
                    mostrarModal("Error",data.mensaje,["Cerrar"])


                }
                else{
                    alert("Ha ocurrido un error al realizar la inscripción");
                }
                  
            }
        },
        error: function() {
            alert("Ha ocurrido un error al realizar la inscripción");
        }
    });
});



});

    <?php
}
//obtenemos el valor del token si este se ha generado
if (isset($_SESSION) && isset($_SESSION["token"])) {
    $token = $_SESSION["token"];
} else {
    $token = "";
}
?>
    $.ajax({
        url: "<?=$urlws?>?action=get_calendarios&token=<?=$token?>&anio=" + anio + "&mes=" + mesActual,
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
            let eventosObtenidos = [];
            data.forEach(function(calendario) {
                var fecha = new Date(calendario.fecha);
                var evento = {
                    date: fecha,
                    eventName: calendario.curso,
                    className: "badge bg-info",
                    dateColor: "red",
                    idCurso: calendario.idcurso,
                    idCalendario: calendario.id,
                    onclick: function(e, data) {
                        muestraDatosCurso("<?=$urlws?>",data.idCurso, idCalendario = data.idCalendario,true);
                    }
                };
                eventosObtenidos.push(evento);
            });
            if (eventosObtenidos.length > 0) {
                calendar.setEvents(eventosObtenidos);
            }
            calendar.setDate(diaHoy);
        }
    });

    
});

/**
    function obtener_cursos() {
        $.ajax({
            url: "<?=$urlws?>?action=get_cursos",
            method: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data);
                data.forEach(function(curso) {
                    $("#curso").append(`<option value="${curso.id}">${curso.titulo}</option>`);
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
*/

</script>
<?php
include_once 'footer.php';
?>