//$(".list-group-item").click(function () {
//    $(".list-group-item").removeClass('active');
//    $(this).addClass('active');
//});

// ======== DESPLEGABLE ======= //

$(".desplegable").click(function () {
    var listGroup = $(this).find(".list-group");
    var arrowIcon = $('#arrow');
    if (listGroup.hasClass("open2")) {
        // ocultar y quitar la clase open
        listGroup.removeClass("open2");
        listGroup.hide();
        // cambiar el icono
        arrowIcon.removeClass('fa-caret-up');
        arrowIcon.addClass('fa-caret-down');
    } else {
        // mostrar y añadir la clase open
        listGroup.addClass("open2");
        listGroup.show();
        // cambiar el icono
        arrowIcon.removeClass('fa-caret-down');
        arrowIcon.addClass('fa-caret-up');
    }
});

$("#myTable").tablesorter({
    widgets: ["filter"],
    widgetOptions:{
        filter_columFilters: true,
        filter_liveSearch: {
            '.no-search': false
        }
    }
});