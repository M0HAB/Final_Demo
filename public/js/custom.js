// Toastr
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


$(document).ready(function() {
    $(window).click(function() {
        $('#arrow-up').css('display', 'none');
    });
});

function toggleArrow(id) {
    var e = document.getElementById(id);    
    if (e.style.display == "inline") {
        e.style.display = "none";
    } else {
        e.style.display = "inline";
    }
}