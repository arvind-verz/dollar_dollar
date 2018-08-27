var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
}
$(".ps-poster-popup .close-popup").click(function(){
    $(this).parent().slideUp();
    $(this).parent().next(".product-popup").slideDown();
});
function backgroundImage() {
    var databackground = $('[data-background]');
    databackground.each(function() {
        if ($(this).attr('data-background')) {
            var image_path = $(this).attr('data-background');
            $(this).css({
                'background': 'url(' + image_path + ')'
            });
        }
    });
}

function parallax() {
    $('.bg--parallax').each(function() {
        var el = $(this),
            xpos = "50%",
            windowHeight = $(window).height();
        if (isMobile.any()) {
            $(this).css('background-attachment', 'scroll');
        } else {
            $(window).scroll(function() {
                var current = $(window).scrollTop(),
                    top = el.offset().top,
                    height = el.outerHeight();
                if (top + height < current || top > current + windowHeight) {
                    return;
                }
                el.css('backgroundPosition', xpos + " " + Math.round((top - current) * 0.2) + "px");
            });
        }
    });
}

function menuBtnToggle() {
    var toggleBtn = $('.menu-toggle'),
        menu = $('.menu');
    toggleBtn.on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        if (!$(this).hasClass('active')) {
            self.addClass('active');
            menu.slideDown(350);
        } else {
            self.removeClass('active');
            menu.slideUp(350);
        }
    });
}

function subMenuToggle() {
    $('body').on('click', '.menu--mobile .menu-item-has-children > .menu-mobile-collapse', function(event) {
        event.preventDefault();
        var current = $(this).parent('.menu-item-has-children');
        current.children('.sub-menu').slideToggle(350);
        current.siblings().find('.sub-menu').slideUp(350);
    });
}

function resizeHeader() {
    var header = $('.header'),
        checkPoint = 1200,
        windowWidth = $(window).innerWidth();
    // mobile
    if (checkPoint > windowWidth) {
        $('.menu').find('.sub-menu').hide();
        header.find('.menu').addClass('menu--mobile');
    } else {
        $('.menu').find('.sub-menu').show();
        header.find('.menu').removeClass('menu--mobile active');
        $('.menu-toggle').removeClass('active');
    }
}

function owlCarousel(element) {
    if (element.length > 0) {
        element.each(function() {
            var el = $(this),
                dataAuto = el.data('owl-auto'),
                dataLoop = el.data('owl-loop'),
                dataSpeed = el.data('owl-speed'),
                dataGap = el.data('owl-gap'),
                dataNav = el.data('owl-nav'),
                dataDots = el.data('owl-dots'),
                dataAnimateIn = (el.data('owl-animate-in')) ? el.data('owl-animate-in') : '',
                dataAnimateOut = (el.data('owl-animate-out')) ? el.data('owl-animate-out') : '',
                dataDefaultItem = el.data('owl-item'),
                dataItemXS = el.data('owl-item-xs'),
                dataItemSM = el.data('owl-item-sm'),
                dataItemMD = el.data('owl-item-md'),
                dataItemLG = el.data('owl-item-lg'),
                dataNavLeft = (el.data('owl-nav-left')) ? el.data('owl-nav-left') : "<i class='fa fa-angle-left'></i>",
                dataNavRight = (el.data('owl-nav-right')) ? el.data('owl-nav-right') : "<i class='fa fa-angle-right'></i>",
                duration = el.data('owl-duration'),
                datamouseDrag = (el.data('owl-mousedrag') == 'on') ? true : false;
            if (el.children.length > 1) {
                el.owlCarousel({
                    animateIn: dataAnimateIn,
                    animateOut: dataAnimateOut,
                    margin: dataGap,
                    autoplay: dataAuto,
                    autoplayTimeout: dataSpeed,
                    autoplayHoverPause: true,
                    loop: dataLoop,
                    nav: dataNav,
                    mouseDrag: datamouseDrag,
                    touchDrag: true,
                    autoplaySpeed: duration,
                    navSpeed: duration,
                    dotsSpeed: duration,
                    dragEndSpeed: duration,
                    navText: [dataNavLeft, dataNavRight],
                    dots: dataDots,
                    items: dataDefaultItem,
                    responsive: {
                        0: {
                            items: dataItemXS
                        },
                        480: {
                            items: dataItemSM
                        },
                        768: {
                            items: dataItemMD
                        },
                        992: {
                            items: dataItemLG
                        },
                        1200: {
                            items: dataDefaultItem
                        }
                    }
                });
            }
        });
    }
}

function bootstrapSelect() {
    $('select.ps-select').selectpicker();
}

function dateTimePicker() {
    $('.datepicker').datepicker();
}

function productCollapse() {
    $('.ps-product__detail').hide();
    $('.ps-product__more').on('click', function(e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).html("Show Less <i class='fa fa-angle-up'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideDown();
        }
        else {
            $(this).removeClass('active');
            $(this).html("Show Detail <i class='fa fa-angle-down'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideUp();
        }

    });
}

function backToTop() {
    var scrollPos = 0;
    var element = $('#totop');
    $(window).scroll(function() {
        var scrollCur = $(window).scrollTop();
        if (scrollCur > scrollPos) {
            // scroll down
            if (scrollCur > 500) {
                element.parent().addClass('active');
            } else {
                element.parent().removeClass('active');
            }
        } else {
            // scroll up
            element.parent().removeClass('active');
        }

        scrollPos = scrollCur;
    });

    element.on('click', function() {
        $('html, body').animate({
            scrollTop: '0px'
        }, 800);
    })
}

function tabs() {
    $('.ps-tab-list > li > a').on('click', function(e) {
        e.preventDefault();
        var $this = $(this),
            target = $this.attr('href');
        $this.closest('.ps-tabs-root').find('.ps-tab').removeClass('active');
        $this.closest('.ps-tabs-root').find($(target)).addClass('active');

    });
}
$(document).ready(function() {
    backgroundImage();
    menuBtnToggle();
    subMenuToggle();
    owlCarousel($('.owl-slider'));
    bootstrapSelect();
    dateTimePicker();
    productCollapse();
    backToTop();
    tabs();
    $( ".only_numeric" ).on( "keydown", function( event ) {
        if(event.keyCode==189)
        {
            event.preventDefault();
        }
    })
    $(".only_numeric").numeric();
    $("input[name='search_value']").each(function(c, obj){
        $(obj).val(addCommas(parseFloat($(obj).val()).toFixed(0))).val();
    });
});
$("input[name='search_value']").on( "change", function() {
    var n = parseInt($(this).val());
    if(n > 999)
    {
        n = Math.round(parseInt(n)/1000)*1000 ;
    }else{
        n = Math.round(parseInt(n)/100)*100 ;
    }
    if(n==0)
    {
        n = 100 ;
    }

    var k = addCommas(n.toFixed(0));
    $(this).val(k);
});
function addCommas(nStr)
{
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 /*+ x2*/;
}

$(".search_type").on("click", function () {

    $(".search_type").removeClass("active");
    $("input[name='filter']").prop("checked", false);
    $(this).addClass("active").find("input[name='filter']").prop("checked", true);
    document.getElementById('search-form').submit();

});
$(".sort-by").on("change", function () {
    document.getElementById('search-form').submit();

});
$(".currency").on("change", function () {
    document.getElementById('search-form').submit();

});
/*$("body").on("click", "img.brand_img", function () {
    if ($(this).prev().prop("checked")) {
        $("input[name='brand_id']").prop("checked", false);
        $("span.brand img").css("border", "none");
    }
    else {
        $("input[name='brand_id']").prop("checked", false);
        $("span.brand img").css("border", "none");
        $(this).prev().prop("checked", true);
        $(this).css({"border": "1px solid #000", "padding": "4px 20px"});
    }
    document.getElementById('search-form').submit();
});*/
$(window).on('load resize', function() {
    resizeHeader();
});

$(window).on('load', function() {
    var i = $(".ps-page--deposit .ps-slider--feature-product>.ps-block--short-product").length;
    $(".ps-page--deposit .ps-slider--feature-product>.owl-slider").css("width",100-(i*20)+"%")
});

function clickSliderhome(id){
 $(".ps-slider--home .owl-dot:nth-child("+id+")").click();
}

$(document).ready(function() {
    $(".aboutpage").click(function () {
        var currentid=$(this).parent('.catListing li').attr('id');
        $('.catListing li').removeClass('selected');
        $("#"+currentid).addClass('selected');
        //alert(currentid);
        $(".target-content").hide();
        $('#' +$(this).attr('target')).show();
        window.dispatchEvent(new Event('resize'));
    });
});

$(document).ready(function() {
 $(".ps-home--links a").eq(0).addClass("active");
 if($(".ps-block--deposit-filter .ps-form--filter .owl-stage .owl-item").length > 9){
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").show();
    }
    else{
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").hide();
    }
})
$(window).on('load resize', function() {
    $('.ps-slider--home').on('changed.owl.carousel', function(e) {
        var n = $(".ps-slider--home .owl-dots .owl-dot.active").index();
        $(".ps-home--links a").removeClass("active");
        $(".ps-home--links a").eq(n).addClass("active");
    });
});

$(document).ready(function() {
    $(".ps-checkbox input[type=checkbox]:checked").parent().parent().addClass("active");
    
    $("body").on("click", ".combine-criteria-padding .ps-checkbox label",function(){
        setTimeout(function(){$(".combine-criteria-padding .ps-checkbox input[type=checkbox]:checked").each(function(){
                $(this).parent().parent().addClass("active");
        });},100);
    });
});