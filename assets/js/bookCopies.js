$(function (){
    $("#book-new-copy").on("click", function (event){
        event.preventDefault();
        let url = $("#book-new-copy").data("path");
        if(confirm("Czy na pewno chcesz dodać kopię")) {
            window.location = url;
        }
    })

    $("#book-copies").dataTable();
})