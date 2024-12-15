$(document).ready(function () {
        $('#timeSheetTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                 'excel', 'pdf', 'print'
            ],
            pageLength: 10
        });
        
    });


   