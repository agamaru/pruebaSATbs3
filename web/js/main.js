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
        //"url": "datatables/js/i18n/Spanish.lang" // NO funciona
        //"url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" // Funciona
        "url": "datatables/js/i18n/spanish.json"
    },
    "columnDefs": [ {
        "targets": 'no',
        "searchable": false,
        "orderable": false
    } ]
});