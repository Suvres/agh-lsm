import '../shared/application'

$(function () {
    $("#booksCopies").DataTable({
        language: {
            "search": "Wyszukaj:",
            "info": "Wpisy  _START_ - _END_ / _TOTAL_",
            "paginate": {
                "first":      "Pierwsza",
                "last":       "Ostatnia",
                "next":       "Następna",
                "previous":   "Poprzednia"
            },
            "lengthMenu":     "Licza _MENU_ wpisów",
        },
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    let column = this;

                    // Create input element
                    let input = document.createElement('input');

                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    }, false);
                });
        }
    });


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


})
