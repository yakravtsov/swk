/*function cycleImages() {
 var $active = $('.splash-bg .active');
 var $next = ($active.next().length > 0) ? $active.next() : $('.splash-bg img:first');
 $next.css('z-index', 2);//move the next image up the pile
 $active.fadeOut(1500, function () {//fade out the top image
 $active.css('z-index', 1).show().removeClass('active');//reset the z-index and unhide the image
 $next.css('z-index', 3).addClass('active');//make the next image the top one
 });
 }*/

$(document).ready(function () {
    //setInterval('cycleImages()', 3000);

    if (/webkit/.test(navigator.userAgent.toLowerCase())) {
        $(':input').attr('autocomplete', 'off');
    }

    var nav_relative = $('.navbar-relative');
    var nav_fixed = $('.navbar-fixed');
    $(window).on('scroll', function () {
        var scrolled = $(window).scrollTop();
        nav_fixed.css('display', scrolled >= nav_relative.offset().top ? 'block' : 'none');
    });

    var help_input = $('.help [type=text]');
    $('.anchor, .navbar a:not(".download_presentation")').on('click', function () {
        var href = $.attr(this, 'href');

        $('html, body').animate({
            scrollTop: $(href).offset().top - 41
        }, 'slow', function () {
            if(href == '#help') { help_input.focus(); }
        });
        return false;
    });

    $('[rel=details]').fancybox({
        helpers: {
            title: {type: 'over'},
            overlay: {
                locked: false
            }
        }
    });

    $('.ill-hover').on('click', function () {
        $('.screenshots .each').eq(0).click();
    });

    $('.callback-trigger').fancybox({
        helpers: {
            overlay: {
                locked: false
            }
        }
    }).on('click', function () {
        $('.callback-form .callback-type').val($(this).data('type'));
    });


    var order = $('.order');
    var order_name = $('.order-name', order);
    var order_qty = $('.order-qty', order);
    var order_space = $('.order-space', order);
    var order_form_id = $('.order-form_id', order);

    var packages = $('.packages table');
    var package_name = $('th',packages);
    var package_qty = $('.tr-qty td',packages);
    var package_space = $('.tr-space td',packages);

    $('.tr-order a').fancybox({
        helpers: {
            overlay: {
                locked: true,
                closeClick: false
            }
        }
    }).on('click', function () {
        var index = $(this).parent('td').index();
        order_name.text(package_name.eq(index).text());
        order_qty.text(package_qty.eq(index).text());
        order_space.text(parseFloat(package_space.eq(index).text()));
        order_form_id.val($(this).data('form_id'));
    });

    //var goals = ['downloaded_quotation','demo_header','demo_screen','']

    var yandexFormGoals = {
        1 : 'demo_header',
        2 : 'demo_screen',
        3 : 'order_min',
        4 : 'order_stand',
        5 : 'order_ext',
        6 : 'free_cons'
    }

    function yaCounterFormCallback(form){
        form.unbind('submit').submit();
    }

    function yaCounterLinkCallback(link){
        link.click();
    }


    $("form").on('submit',function(e) {
        var form_id = $(this).find('[name="Landing[form_id]"]').val();
        yaCounter33339158.reachGoal(yandexFormGoals[form_id]);
    });

    $('.download_presentation').on('click',function(e){
        yaCounter33339158.reachGoal('downloaded_quotation');
       /* var _this = $(this);
        e.preventDefault();
        yaCounter33339158.reachGoal('downloaded_quotation');
        _this.click();*/
    });


    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter33339158 = new Ya.Metrika({
                    id: 33339158,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");

});