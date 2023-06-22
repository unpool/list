import Dropzone from "dropzone";

let CSRF_TOKEN = document
    .querySelector('meta[name="_token"]')
    .getAttribute("content");

Dropzone.autoDiscover = false;
if (document.getElementById("productDropzone")) {
    let myDropzone = new Dropzone("#productDropzone", {
        maxFiles: 1,
        maxFilesize: 2000, // 2GB
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.mp4,.mp3,.mkv,.org",
        dictDefaultMessage:
            "فایل‌ را انتخاب کنید و یا بکشید و در اینجا رها کنید"
    });
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("id", document.getElementById("productId").value);
        formData.append("_token", CSRF_TOKEN);
    });
}
