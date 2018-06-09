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
        $('.coll-btn').addClass('collapsed');
        $('.comments-block').removeClass('show');
    });
    
    $('.navbar-nav li a:not(#msg-dropdown)').click(function() {
        $('#arrow-up').css('display', 'none');
    });

    $('#btn-scroll').click(function() {
        var top = $('#top');
        $('html, body').animate({scrollTop: $(top).offset().top}, 'slow');
        return false;
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() > 200) {
            $('#btn-scroll').fadeIn(300);            
            $('#btn-scroll').addClass('show');
        } else {
            $('#btn-scroll').fadeOut(300);                        
            $('#btn-scroll').removeClass('show');
        }
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
