// side bar
$('.side-bar-toggle').click(function() {
    $(this).toggleClass("click");
    $('.sidebar').toggleClass("show");
});

$('.sidebar').mouseleave(function() {
    setTimeout(() => {
        if ($(".sidebar").hasClass('show')) {
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
        }
    }, 500);
});

//navbar dropdown
$('.dropdown-toggle').mouseenter(function() {
    let id = $(this).attr('id');
    setTimeout(() => {
        if ($("#" + id + ":hover").length != 0) {
            $(this).next(".dropdown-menu").fadeIn("slow");
        }
    }, 300);
});

$('.dropdown-toggle').mouseleave(function() {
    setTimeout(() => {
        let label = $(this).attr('id');
        if ($("#" + label + "-dropdown:hover").length == 0) {
            $("#" + label + "-dropdown").fadeOut();
        }
    }, 300);
});
$('.dropdown-menu').mouseleave(function() {
    setTimeout(() => {
        let label = $(this).attr('id');
        let togleLabel = label.replace("-dropdown", "");
        if ($("#" + togleLabel + ":hover").length == 0) {
            $("#" + label).fadeOut();
        }
    }, 300);
});


$(".side-bar-category-toggle").click(function() {
    console.log("Clicked");
    $(this).toggleClass('fa-angle-down');
    $(this).toggleClass('fa-angle-up');
});

$(".search-btn").click(function() {
    if ($("#searh-field").val().length > 0) {
        $("#search-form").submit();
    }
});