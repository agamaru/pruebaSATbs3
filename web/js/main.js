//$(".list-group-item").click(function () {
//    $(".list-group-item").removeClass('active');
//    $(this).addClass('active');
//});

/* ======== DESPLEGABLE ======= */

$(".desplegable").click(function () {
    var listGroup = $(this).find(".list-group");
    var arrowIcon = $('#arrow');
    if (listGroup.hasClass("open2")) {
        // ocultar y quitar la clase open
        listGroup.removeClass("open2");
        listGroup.hide();
        // cambiar el icono
        arrowIcon.removeClass("fa-caret-up");
        arrowIcon.addClass("fa-caret-down");
    } else {
        // mostrar y añadir la clase open
        listGroup.addClass("open2");
        listGroup.show();
        // cambiar el icono
        arrowIcon.removeClass("fa-caret-down");
        arrowIcon.addClass("fa-caret-up");
    }
});


/* ======== SELECT2 ========= */

$("select[class!='input-sm']").select2({
    theme: "bootstrap"
});


/* ======== DATATABLES ======== */

$('.dt').DataTable({
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    "columnDefs": [ {
        "targets": 'no',
        "searchable": false,
        "orderable": false
    } ]
});