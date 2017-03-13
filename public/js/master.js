// jQuery to collapse the navbar on scroll
function collapseNavbar() {
    if ($(".navbar-welcome").offset().top < 50) {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    }
}

$(window).scroll(collapseNavbar);
$(document).ready(collapseNavbar);
