$(function () {
    $('select').select2({
        theme: 'bootstrap4',
        templateResult: formatCopy,
    });

    $('select').on('select2:select', function (e) {
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
}