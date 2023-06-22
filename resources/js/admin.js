"use strict";
// JQuery
import $ from "./../../public/plugins/jquery/jquery.min";
window.$ = window.jQuery = $;

window.$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content")
    }
});
// end of - JQuery

import "./../../public/plugins/bootstrap/js/bootstrap.bundle.min";
import "./../../public/js/admin/adminlte.min";

// Datatables
import dt from "./../../public/plugins/datatables/dataTables.bootstrap4";
window.$.fn.DataTable = dt;
$(".datatable").DataTable({
    language: {
        sEmptyTable: "هیچ داده ای در جدول وجود ندارد",
        sInfo: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
        sInfoEmpty: "نمایش 0 تا 0 از 0 رکورد",
        sInfoFiltered: "(فیلتر شده از _MAX_ رکورد)",
        sInfoPostFix: "",
        sInfoThousands: ",",
        sLengthMenu: "نمایش _MENU_ رکورد",
        sLoadingRecords: "در حال بارگزاری...",
        sProcessing: "در حال پردازش...",
        sSearch: "جستجو:",
        sZeroRecords: "رکوردی با این مشخصات پیدا نشد",
        oPaginate: {
            sFirst: "ابتدا",
            sLast: "انتها",
            sNext: "بعدی",
            sPrevious: "قبلی"
        },
        oAria: {
            sSortAscending: ": فعال سازی نمایش به صورت صعودی",
            sSortDescending: ": فعال سازی نمایش به صورت نزولی"
        }
    }
});
// end of - Datatables

import "./admin/dom/index";
