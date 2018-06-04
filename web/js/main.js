$(".list-group-item").click(function () {
    $(".list-group-item").removeClass('active');
    $(this).addClass('active');
});

$("#myTable").tablesorter({
    widgets: ["filter"],
    widgetOptions:{
        columns: ["secondary"],
        filter_columFilters: true
    }
});