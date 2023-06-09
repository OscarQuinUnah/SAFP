var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#imagenmuestra").hide();
    //Mostramos los permisos
    $.post("../controller/usuario.php?op=permisos&id=", function (r) {
        $("#permisos").html(r);
    });
}

//Función limpiar
function limpiar() {

}
//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#generar-reporte").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#generar-reporte").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        /*"scrollY": 200,  navegar en el datatable
        "scrollX": true, */
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        
        responsive: true,
        "scrollX": true,

        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        lengthMenu: [
            [ 5, 10, 25, 50, -1 ],
            [ '5 filas','10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: [
                  {
                        extend: 'pageLength',
                        text: 'LONGITUD DE LA PÁGINA',
                   },
                    {
                        extend: 'print',
                        text: 'IMPRIMIR',
                        title: 'Usuarios BYTE SEVEN'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Usuarios BYTE SEVEN'
                    },
		        ],
        "ajax": {
            url: '../controller/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20, //Paginación
        "order": [[0, "desc"]], //Ordenar (columna,orden)
        language: {
            zeroRecords: 'No hay registros para mostrar.',
            info: "Mostrando página _PAGE_ de _PAGES_ páginas",
            search: 'BUSCAR',
            emptyTable: 'La tabla está vacia.',
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Ultimo",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior",
            }
        }
    }).DataTable();
}




init();
