$(document).ready(function() {
    //modules
    if(typeof(obSlider) == "object"){
        obSlider.init();
    }
    //end

    //toggle class
    $("body").on("click", ".js-toggle_class", function(e){
        e.preventDefault();
        var $target,
            className = $(this).attr("data-class");

        $target = $(this).attr("data-is_parent") == "true"
            ? $(this).closest($(this).attr("data-target"))
            : $($(this).attr("data-target"));
        if (!$target) {
            return;
        }
        if ($target.hasClass(className)) {
            $target.removeClass(className);
            $(this).removeClass(className);
        } else {
            $target.addClass(className);
            $(this).addClass(className);
        }
    });
    //end

    //plugins
    $('.dropdown-toggle').dropdown();

    if (typeof baguetteBox == "object") {
        baguetteBox.run('.js-compact-gallery', { animation: 'slideIn'});
    }
    //end
});
