import '../shared/application'

$(function (){

    $(".import-button").on("click", function (event){
        event.preventDefault();
        let url = $(this).data("path");
        window.location = url;
        
    })

    $("#book-copies").dataTable();
})