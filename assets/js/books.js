$(() => {
    $('#bookTable').DataTable({
        dom: 'Plfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [3]
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [4]
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [5]
            }
        ]
    });
})