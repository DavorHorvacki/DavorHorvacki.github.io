/* Toggle Navigation Close On Click */

$('.navbar-collapse').click(function() {
    $('.navbar-collapse').collapse('hide');
});

/* Toggle Navigation Close On Click End */

/* Top Navigation Shrink On Scroll */

function collapseNavbar() {
    if ($('.navbar').offset().top > 250) {
        $('.navbar-fixed-top').addClass('top-collapse');
    } else {
        $('.navbar-fixed-top').removeClass('top-collapse');
    }
}

$(window).scroll(collapseNavbar);
$(document).ready(collapseNavbar);

/* Top Navigation Shrink On Scroll End */

/* Progress Animation On Scroll */

function updateProgress(num1, num2){
    var percent = Math.ceil( num1 / num2 * 100 ) + '%';
    document.getElementById('progress').style.width = percent;
}

window.addEventListener('scroll', function(){
    var top = window.scrollY;
    var height = document.body.getBoundingClientRect().height - window.innerHeight;
    updateProgress(top, height);
});

/* Progress Animation On Scroll End */

/* Smooth Scrolling on Click */

$('#nav .navbar-nav li>a, .navbar-header>a, .fa-caret-up').click(function(){
    var link = $(this).attr('href');
    var position = $(link).offset().top;
    $('body,html').animate({
        scrollTop: position
    }, 1000);
});

/* Smooth Scrolling on Click End */