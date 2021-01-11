$(() => {
    $('#bookTable').DataTable({
        dom: 'Plfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: false
                },
                targets: [0,1,2]
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [1,4,5]
            },
        ]
    });
})