$(() => {
    $('#bookTable').DataTable({
        dom: 'Plfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: false
                },
                targets: [0,1,2,5]
            },
            {
                searchPanes: {
                    show: true
                },
                targets: [3,4,6]
            },
        ]
    });
})