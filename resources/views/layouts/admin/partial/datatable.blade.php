
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function () {
        $('.custom_datatable').DataTable({
            "language": {
                "emptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "info": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "infoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "infoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "infoThousands": ",",
                "lengthMenu": "نمایش _MENU_ ردیف",
                "loadingRecords": "در حال بارگزاری...",
                "processing": "در حال پردازش...",
                "search": "جستجو:",
                "zeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "paginate": {
                    "first": "برگه‌ی نخست",
                    "last": "برگه‌ی آخر",
                    "next": "بعدی",
                    "previous": "قبلی"
                },
                "aria": {
                    "sortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            },
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-primary glyphicon glyphicon-duplicate' },
                { extend: 'csv', className: 'btn btn-primary glyphicon glyphicon-save-file' },
                //{ extend: 'excel', className: 'btn btn-success glyphicon glyphicon-list-alt' },
                { extend: 'pdf', className: 'btn btn-primary glyphicon glyphicon-file' },
                { extend: 'print', className: 'btn btn-primary glyphicon glyphicon-print' }
            ]
        });
    });
</script>
