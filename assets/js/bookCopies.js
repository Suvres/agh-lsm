$(function (){


    $(".import-button").on("click", function (event){
        event.preventDefault();
        let url = $(this).data("path");
        if(confirm($(this).data("text"))) {
            window.location = url;
        }
    })

    $("#book-copies").dataTable();
})