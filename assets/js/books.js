$(() => {
    $('#bookTable').DataTable({
        dom: 'Plfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [2]
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [4]
            }
        ]
    });
})