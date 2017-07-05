$(document).ready(function () {
    $("select.level").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue) {
                $(".levels").not("." + optionValue).fadeOut(600);
                $("." + optionValue).fadeIn(600);
            } else {
                $(".levels").fadeOut(600);
            }
        });
    }).change();
});
$(document).ready(function () {
    $("select.publish").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue) {
                $(".publisher").not("." + optionValue).fadeOut(600);
                $("." + optionValue).fadeIn(600);
            } else {
                $(".publisher").fadeOut(600);
            }
        });
    }).change();
});
$(document).ready(function () {
    $("select.county").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue) {
                $(".counties").not("." + optionValue).fadeOut(600);
                $("." + optionValue).fadeIn(600);
            } else {
                $(".counties").fadeOut(600);
            }
        });
    }).change();
});