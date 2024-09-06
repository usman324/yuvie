<script src="{{ asset('assets/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


{{-- <script src="{{ asset('theme/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('theme/js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('theme/js/datatables/buttons.colVis.min.js') }}"></script> --}}
<script>
    var myTable = '';
    var datatable_setting = {
        responsive: true,
        autoWidth: false,
        order: [],
        searching: false,
        paging: true,
        aLengthMenu: [
            [10, 25, 100, 500, 999, -1],
            [10, 25, 100, 500, 999, "@lang('All')"]
        ],
        dom: 'lBfrtip',
    };
</script>
<script>
    var datatable_buttons = [
        // 'copy', 'csv', 'excel', 'pdf', 'print'
    ];
</script>
