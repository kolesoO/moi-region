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

    //iframe
    $('iframe').each(function () {
        $(this).wrap('<div class="iframe-wrapper"></div>');
    });
    //end

    //plugins
    $('.dropdown-toggle').dropdown();

    if (typeof baguetteBox == "object") {
        baguetteBox.run('.js-compact-gallery', { animation: 'slideIn'});
    }
    //end
});

//bitrix
BX.ready(function() {
    BX.showWait = function(a) {
        BX.lastNode = a;
        BX.addClass(BX(a), "loading")
    };
    BX.closeWait = function(a) {
        if (!a) {
            a = BX.lastNode
        }
        BX.removeClass(BX(a), "loading")
    };
    var ck = document.getElementById('popup-cookie');
    if (!!ck) {
        ck.classList.add('active');
        var tm = new Date();
        tm.setTime(tm.getTime() + (1 * 24 * 60 * 60 * 1000));
        document.cookie = 'cookie_policy=true;expires=' + tm.toGMTString() + ';path=/'
    }
});
//end
