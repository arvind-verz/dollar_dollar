var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
}
$(".ps-poster-popup .close-popup").click(function () {
    $(this).parent().slideUp();
    $(this).parent().next(".product-popup").slideDown();
});
function backgroundImage() {
    var databackground = $('[data-background]');
    databackground.each(function () {
        if ($(this).attr('data-background')) {
            var image_path = $(this).attr('data-background');
            $(this).css({
                'background': 'url(' + image_path + ')'
            });
        }
    });
}

function parallax() {
    $('.bg--parallax').each(function () {
        var el = $(this),
            xpos = "50%",
            windowHeight = $(window).height();
        if (isMobile.any()) {
            $(this).css('background-attachment', 'scroll');
        } else {
            $(window).scroll(function () {
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
    toggleBtn.on('click', function (e) {
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
    $('body').on('click', '.menu--mobile .menu-item-has-children > .menu-mobile-collapse', function (event) {
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

function bootstrapSelect() {
    $('select.ps-select').selectpicker();
}

function dateTimePicker() {
    $('.datepicker').datepicker();
}

function productCollapse() {
    $('.ps-product__detail').hide();
    $('.ps-product__more').on('click', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).html("Show Less <i class='fa fa-angle-up'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideDown();
        }
        else {
            $(this).removeClass('active');
            $(this).html("More Detail <i class='fa fa-angle-down'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideUp();
        }

    });
}
function moreInfo() {
    $('.ps-product__info').on('click', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).html("Info Less <i class='fa fa-angle-up'></i>")
            $(this).closest('.ps-product').find('.ps-table.ps-table--product').slideDown();
            $(this).closest('.ps-product').find('.ps-table-wrap').slideDown();
        }
        else {
            $(this).removeClass('active');
            $(this).html("More Info <i class='fa fa-angle-down'></i>")
            $(this).closest('.ps-product').find('.ps-table.ps-table--product').slideUp();
            $(this).closest('.ps-product').find('.ps-table-wrap').slideUp();
        }
        $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").find(".ps-product__table"));
        $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").children(".ps-table-wrap"));
    });
}
function backToTop() {
    var scrollPos = 0;
    var element = $('#totop');
    $(window).scroll(function () {
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

    element.on('click', function () {
        $('html, body').animate({
            scrollTop: '0px'
        }, 800);
    })
}

function tabs() {
    $('.ps-tab-list > li > a').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            target = $this.attr('href');
        $this.closest('.ps-tabs-root').find('.ps-tab').removeClass('active');
        $this.closest('.ps-tabs-root').find($(target)).addClass('active');

    });
}

$(document).ready(function () {
    backgroundImage();
    menuBtnToggle();
    subMenuToggle();
    bootstrapSelect();
    dateTimePicker();
    productCollapse();
    backToTop();
    tabs();
    moreInfo();
    $(".only_numeric").on("keydown", function (event) {
        if (event.keyCode == 189) {
            event.preventDefault();
        }
    })
    $(".only_numeric").numeric();
    $("input[name='search_value']").each(function (c, obj) {
        $(obj).val(addCommas(parseFloat($(obj).val()).toFixed(0))).val();
    });
});
$("input[name='search_value']").on("change", function () {
    var n = $(this).val();
    if (!n) {
        n = $('#placement-id').data('value');
    }
    n = parseInt(n);
    if (n > 999) {
        n = Math.round(parseInt(n) / 1000) * 1000;
    } else {
        n = Math.round(parseInt(n) / 100) * 100;
    }
    if (n == 0) {
        n = $('#placement-id').data('value');
    }
    var k = addCommas(n.toFixed(0));
    $(this).val(k);
});
function addCommas(nStr) {
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
    var filterValue = $(this).addClass("active").find("input[name='filter']").val();
    if (filterValue == 'Interest') {
        $(".sort-by").prop('selectedIndex', 2);
    } else {
        $(".sort-by").prop('selectedIndex', 1);
    }
    $("input[name='filter']").prop("checked", false);
    $(this).addClass("active").find("input[name='filter']").prop("checked", true);
    document.getElementById('search-form').submit();

});
$(".sort-by").on("change", function () {
    if ($(this).val() !== '') {
        document.getElementById('search-form').submit();
    }

});
$(".currency").on("change", function () {
    document.getElementById('search-form').submit();

});

$(".content-detail").on("click", function () {
    var headingText = $(this).text();
    var formulaDetailId = $(this).data('formula');

    if (headingText == "SHOW DETAILS") {
        $(".content-detail").html("SHOW DETAILS");
        $(this).html("LESS DETAILS");
        var detailId = $(this).data('detail-id');
        var content = $('#' + detailId).html();
        $('#formula-' + formulaDetailId + '-details').html(content);
        $('#formula-' + formulaDetailId + '-details').css('display', 'block');

    } else {
        $(this).html("SHOW DETAILS");
        $('#formula-' + formulaDetailId + '-details').css('display', 'none');
    }

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
$(window).on('load resize', function () {
    resizeHeader();
});

$(window).on('load', function () {
    var i = $(".ps-page--deposit .ps-slider--feature-product>.ps-block--short-product").length;
    $(".ps-page--deposit .ps-slider--feature-product>.owl-slider").css("width", 100 - (i * 20) + "%")
});

function clickSliderhome(id) {
    $(".ps-slider--home .owl-dot:nth-child(" + id + ")").click();
}
function checkOtherValidation(obj) {

    var textareaLength = $(obj).val().length;
    var target = $(obj).data('target');

    if (textareaLength == 0) {
        $('#'+target).prop('checked', false);
    }
    else {
        $('#' + target).prop('checked', true);
    }
}
$('#time-5').change(function () {
    if (!$(this).is(":checked")) {
        $('#other-value').val("");
    }
});
$(document).ready(function () {
    $(".aboutpage").click(function () {
        var currentid = $(this).parent('.catListing li').attr('id');
        $('.catListing li').removeClass('selected');
        $("#" + currentid).addClass('selected');
        //alert(currentid);
        $(".target-content").hide();
        var target = $(this).attr('target');
        setTimeout(function(){ $('#' + target ).show() }, 100);
        window.dispatchEvent(new Event('resize'));
    });
});

$(document).ready(function () {
    $(".ps-home--links a").eq(0).addClass("active");
    if ($(".ps-block--deposit-filter .ps-form--filter .owl-stage .owl-item").length > 9) {
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").show();
    }
    else {
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").hide();
    }
})
$(window).on('load resize', function () {
    $('.ps-slider--home').on('changed.owl.carousel', function (e) {
        var n = $(".ps-slider--home .owl-dots .owl-dot.active").index();
        $(".ps-home--links a").removeClass("active");
        $(".ps-home--links a").eq(n).addClass("active");
    });
});

$(document).ready(function () {
    $(".ps-checkbox input[type=checkbox]:checked").parent().parent().parent().parent().addClass("active");

    $("body").on("click", ".combine-criteria-padding .ps-checkbox label", function () {
        setTimeout(function () {
            $(".combine-criteria-padding .ps-checkbox input[type=checkbox]:checked").each(function () {
                $(this).parent().parent().parent().parent().addClass("active");
            });
        }, 100);
    });
});

$(document).ready(function () {
    // $("#totop span").html("");
    $(".menu > li.menu-item-has-children").append("<span></span>");
    $("body").on("click", ".menu--mobile > li.menu-item-has-children > span", function (e) {
        e.preventDefault();
        $(".menu--mobile > li > ul ").slideUp();
        if( $(this).parent().hasClass("active") ){
            $(this).parent().removeClass("active");
            $(this).parent().children(".sub-menu").slideUp();
        }
        else{
            $(".menu--mobile > li").removeClass("active");
            $(this).parent().addClass("active");
            $(this).parent().children(".sub-menu").slideDown();
        }
    });
    $("body").on("click", ".ps-block--legend-table .ps-block__header", function () {
        $(this).next().slideToggle();
    });
    $("body").on("click", ".ps-wiget--footer h3", function () {
        $(this).next().slideToggle();
    });
    $(".ps-block--legend-table .ps-block__header").append("<span></span>");

    $(".ps-block--short-product.second.highlight.sp-only").parent().addClass("sp-only");

    $(".ps-list--sidebar.menu-sibar .current").append("<div><span></span></div>");
    $(".ps-list--sidebar.menu-sibar .current div").click(function () {
        if ($(this).parent().hasClass("active")) {
            $(this).parent().removeClass("active");
        }
        else {
            $(this).parent().addClass("active");
        }
        $(this).parent().nextAll(".ps-list--sidebar.menu-sibar li").slideToggle();
    })

    /*$(".ps-page--deposit .ps-product--2 .ps-criteria-detail .ps-block--product-info .ps-block__content .ps-block__more").click(function () {
     var n = $(this).attr("href").replace("#", "");
     $(".ps-page--deposit .ps-product--2 .ps-criteria-detail .ps-criteria-detail__content").css("display", "none");
     $(".ps-criteria-detail__content#" + n).css("display", "block");
     })*/
});