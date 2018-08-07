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
        $(obj).val(addCommas(parseFloat($(obj).val()).toFixed(2))).val();
    });
});
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;
}
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