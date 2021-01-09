$(function () {
    $('#search-copy').select2({
        theme: 'bootstrap4',
        templateResult: formatCopy,
    }).on('select2:select', function (e) {
        loadInfo(e)
    });

})


function formatCopy (copy) {
    if(isNaN(copy.id)) {
        return copy.text
    }

    return $('<span>' + copy.element.dataset.book  + " <=> "+ copy.text+'</span>');
}

function loadInfo(e) {
    let data = e.params.data;
    if(isNaN(data.id)){
        return;
    }
    let url = data.element.dataset.url;
    fetch(url, {method: "POST"})
        .then(response => response.text())
        .then((body) => {
            $("#book-info").html(body)
        })
        .then(() => {
            loan();
        })
}

function loan(){
    $("#new-loan").on('click', function (){
        fetch($(this).data('path'), {method: "POST"})
            .then(response => response.text())
            .then((body) => {
                $("#book-loan").html(body);
            })
            .then(() => {
                $("#book_loan_form_user").select2({
                    theme: 'bootstrap4',
                })
            });
    })

    $("#loan-return").on("click", function (e) {
        e.preventDefault();
        if(confirm("Czy na pewno chcesz oddać tą książkę")) {
            postLink(e.target.href);
        }

    })
}