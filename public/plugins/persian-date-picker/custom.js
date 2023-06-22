$(document).ready(function() {
    var PersianDatePickerJustDate = $(".persian-date-picker--just-date");
    // PersianDatePickerJustDate.pDatepicker({
    //     format: "YYYY/MM/DD"
    // });
    PersianDatePickerJustDate.toArray().forEach(item => {
        let temp = $(item).pDatepicker({
            format: "YYYY/MM/DD"
        });
        if ($(item).attr("default-value")) {
            // console.log($(item).attr("default-value"));
            temp.setDate($(item).attr("default-value") * 1000);
        }
    });
});
