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
    $(this).parents(".ps-poster-popup").slideUp();
    $(this).parents(".ps-poster-popup").next(".product-popup").slideDown();
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
    $('.ps-page--deposit').on('click', '.ps-product__more', function (e) {
        e.preventDefault();
        $(this).parents(".ps-product__content").find("p").removeClass("active");
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).html("Less Details <i class='fa fa-angle-up'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideDown();
        }
        else {
            $(this).removeClass('active');
            $(this).html("More Details <i class='fa fa-angle-down'></i>")
            $(this).closest('.ps-product').find('.ps-product__detail').slideUp();
        }
        // $(this).parents(".ps-product__content").find(".table-new").parent().before("<div class='row'><div class='scroll-table'></div></div>");
        $(this).parents(".ps-product__content").find(".scroll-table").css({
            "height": "20px",
            "width": $(this).parents(".ps-product__content").find(".table-new").width() + "px"
        });

        $(this).parents(".ps-product__content").find(".scroll-table").parent().scroll(function () {
            $(this).parents(".ps-product__content").find(".table-new").parent().scrollLeft($(this).parents(".ps-product__content").find(".scroll-table").parent().scrollLeft());
        });
        $(".ps-product__detail.table .mCSB_horizontal.mCSB_inside>.mCSB_container").css("left", "0px");
    });
    //if (isMobile.any()) {
    if (screen.width < 768) {
        $('.ps-page--deposit').on('click', '.ps-product__more', function (e) {
            e.preventDefault();
            $(this).next().html("More Data <i class='fa fa-angle-down'></i>");
            $(this).next().removeClass('active');
            $(this).closest('.ps-product').find('.ps-table.ps-table--product').slideUp();
            $(this).closest('.ps-product').find('.ps-table-wrap').slideUp();
            $(this).closest('.ps-product').find('.ps-table-wrap').removeClass("active");
            $(this).parents(".ps-product__content").find(".ps-table.ps-table--product").after($(this).parents(".ps-product__content").find(".ps-product__detail > .ps-criteria-detail > p"));
            $(this).parents(".ps-product__content").find("p").removeClass("is-active");

            $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").find(".ps-poster-popup"));
        })
        // }
    }

}

function moreInfo() {
    $('.ps-page--deposit').on('click', '.ps-product__info', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).html("Less Data <i class='fa fa-angle-up'></i>")
            $(this).closest('.ps-product').find('.ps-table.ps-table--product').slideDown();
            $(this).closest('.ps-product').find('.ps-table-wrap').slideDown();
            $(this).closest('.ps-product').find('.ps-table-wrap').addClass("active");
            $(this).parents(".ps-product__content").find("p").addClass("is-active");
            $(this).closest('.ps-product').find('.ps-product__detail').slideUp();
            $(this).closest('.ps-product').find(".ps-product__more").html("More Details <i class='fa fa-angle-down'></i>");
            $(this).closest('.ps-product').find(".ps-product__more").removeClass("active");
        }
        else {
            $(this).removeClass('active');
            $(this).html("More Data <i class='fa fa-angle-down'></i>")
            $(this).closest('.ps-product').find('.ps-table.ps-table--product').slideUp();
            $(this).closest('.ps-product').find('.ps-table-wrap').slideUp();
            $(this).closest('.ps-product').find('.ps-table-wrap').removeClass("active");
            $(this).parents(".ps-product__content").find("p").removeClass("is-active");
        }
        $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").find(".ps-product__table"));
        $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").find(".ps-table-wrap"));
    });
    //if (isMobile.any()) {
    if (screen.width < 768) {
        $('.ps-page--deposit').on('click', '.ps-product__info', function (e) {
            e.preventDefault();
            $(this).prev().html("More Details <i class='fa fa-angle-down'></i>");
            $(this).prev().removeClass('active');
            $(this).closest('.ps-product').find('.ps-product__detail').slideUp();
            $(this).parents(".ps-product__content").find(".ps-table.ps-table--product").after($(this).parents(".ps-product__content").find(".ps-product__detail > .ps-criteria-detail > p"));
            $(this).parents(".ps-product ").find(".ps-loan-right").after($(this).parents(".ps-product ").find(".loan_table"));
            $(this).parents(".ps-product ").find(".loan_table .ps-table-wrap").css('display', 'table');
            $(this).parents(".ps-product__content").find(".ps-product__panel").after($(this).parents(".ps-product__content").find(".ps-poster-popup"));
            pdTableP();
            $(this).parents(".ps-product ").find(".ps-product__detail>p.is-active,.ps-product__detail>.ps-criteria-detail>.ps-criteria-detail>p.is-active").appendTo($(this).parents(".ps-product ").find(".ps-table-wrap"));
            /*$(".all-in .ps-product .ps-table-wrap").each(function(){
             $(this).find("p.is-active").appendTo($(this).parent());
             });*/
        })
        // }
    }
}
function backToTop() {
    var scrollPos = 0;
    var element = $('#totop');
    $(window).scroll(function () {
        var scrollCur = $(window).scrollTop();
        if ($(window).width() > 767) {
            if (scrollCur > 300) {
                // scroll down
                // if (scrollCur > 00) {
                element.parent().addClass('active');
                // } else {
                //     element.parent().removeClass('active');
                // }
            } else {
                // scroll up
                element.parent().removeClass('active');
            }
        } else {
            if (scrollCur > 0) {
                // scroll down
                // if (scrollCur > 00) {
                element.parent().addClass('active');
                // } else {
                //     element.parent().removeClass('active');
                // }
            } else {
                // scroll up
                element.parent().removeClass('active');
            }
        }

        scrollPos = scrollCur;

        // if (isMobile.any()) {
        //     setTimeout(function(){
        //         $('#totop').parent().removeClass('active');
        //     },2000)
        // }
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
        /*$this.closest('.ps-tabs-root').find('.ps-tab').removeClass('active');
         $this.closest('.ps-tabs-root').find($(target)).addClass('active');*/
        $(".ps-block--short-product img").matchHeight();

    });
}

function respon() {
    var wscreen = $(window).outerWidth();
    $('.ps-slider--home img').css({maxWidth: wscreen});

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
    respon();
    var numericCharCode = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 101, 102, 103, 104, 105, 8, 9, 13];
    var countryCode = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 101, 102, 103, 104, 105, 187, 107, 8, 9, 13];
    $(".only_numeric").on("keydown", function (event) {
        if (jQuery.inArray(event.keyCode, numericCharCode) == -1) {
            event.preventDefault();
        }
    })

    $("input[name='country_code'], input[name='telephone']").on('keydown', function (event) {
        if (jQuery.inArray(event.keyCode, countryCode) == -1) {
            event.preventDefault();
        }
    });
    $("input[name='search_value']").each(function (c, obj) {
        $(obj).val(addCommas(parseFloat($(obj).val()).toFixed(0))).val();
    });

    $(".ps-form__option").before("<div class='product-mobile'>Sort by<span></span></div>")
    $(".product-mobile").click(function () {
        $(".owl-carousel").trigger('refresh.owl.carousel');
        $(this).next().slideToggle("slow");
    });
    if ($(window).width() < 1201) {
        //   $(".ps-page--deposit .ps-slider--feature-product").each(function(){
        //       $(this).before("<div class='ps-block--legend-table'><div class='ps-block__header show-slider'><h3>Slider</h3><span></span></div></div>");
        //   });
        //   $(".show-slider").click(function(){
        //       $(this).parent().parent().find(".ps-slider--feature-product").slideToggle("slow");
        //   });
    } else {
        $(".ps-page--deposit .ps-slider--feature-product").each(function () {
            $(this).find(".ps-block--legend-table").hide();
        });
    }
    if ($(window).width() < 991) {
        $(".ps-home-fixed-deposit .ps-tab-list").before("<div class='ps-block--legend-table show-tab-list'><div class='ps-block__header'><h3>" + $(".ps-home-fixed-deposit .ps-tab-list .current a").text() + "</h3><span></span></div></div>");
        $(".show-tab-list").click(function () {
            $(this).parent().find(".ps-tab-list").slideToggle("slow");
        });
        $(".ps-home-fixed-deposit .ps-tab-list li").click(function () {
            $(".show-tab-list h3").text($(".ps-home-fixed-deposit .ps-tab-list .current a").text());
            $(".ps-tab-list").slideToggle("slow");
        });
        $(".ps-form__option.flex-box label").click(function () {
            $(this).next().slideToggle("slow");
        });
    } else {
        $(".show-tab-list").hide();
    }
});
$("input[name='search_value']").on("change", function () {
    var n = $(this).val();
    n = $(this).val().replace(/,/g, ''),
        n = +n;


    if (!n || isNaN(n)) {
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
    /* if (filterValue == 'Interest') {
     $(".sort-by").prop('selectedIndex', 2);
     } else {
     $(".sort-by").prop('selectedIndex', 1);
     }*/
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

$(".ps-block__content").click(function () {
    var headingText = $(this).find(".content-detail").text();
    // var formulaDetailId = $(this).find(".content-detail").data('formula');
    $(this).parents(".ps-criteria-detail").find(".ps-block__content").removeClass("active");
    $(this).parents(".ps-criteria-detail").find(".ps-criteria-detail__content").slideUp();

    if (headingText == "Show DETAILS" || headingText == "SHOW DETAILS") {
        $(".ps-block--product-info .ps-block__more").text("Show DETAILS");
        $(this).find(".content-detail").text("LESS DETAILS");
        $(this).addClass("active");
        var a = $(this).parents(".ps-block--product-info").index();
        $(this).parents(".ps-criteria-detail").find(".ps-criteria-detail__content").slideUp();
        $(this).parents(".ps-criteria-detail").find(".ps-criteria-detail__content").eq(a).slideDown();
        // var headtxt = $(this).parents(".ps-block--product-info").find("h5").text();
        // $(".ps-criteria-detail__content").each(function(){
        //     if($(this).find("h5 strong").text() == headtxt){
        //         $(this).slideDown();
        //     }
        // });


    } else {
        $(this).find(".content-detail").text("Show DETAILS");
        var a = $(this).parents(".ps-block--product-info").index();
        $(this).parents(".ps-criteria-detail").find(".ps-criteria-detail__content").eq(a).slideUp();
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
    respon();
});

$(window).on('load', function () {
    var i = $(".ps-page--deposit .ps-slider--feature-product>.ps-block--short-product").length;
    $(".ps-page--deposit .ps-slider--feature-product>.owl-slider").css("width", 100 - (i * 20) + "%");

});

function clickSliderhome(id) {
    if (screen.width < 768) {
        id = id + 1;
        if ($(".ps-slider--home .owl-dot").length < id) {
            id = 1;
        }
        $(".ps-slider--home .owl-dot:nth-child(" + id + ")").click();
    } else {
        $(".ps-slider--home .owl-dot:nth-child(" + id + ")").click();
    }
    $('.ps-slider--home').on('changed.owl.carousel', function (e) {
        var n = $(".ps-slider--home .owl-controls .owl-dots .active").index();
        $(".ps-home--links a").removeClass("active");
        $(".ps-home--links a").eq(n).addClass("active");
    });
}
function checkOtherValidation(obj) {

    var textareaLength = $(obj).val().length;
    var target = $(obj).data('target');

    if (textareaLength == 0) {
        $('#' + target).prop('checked', false);
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
/*$(document).ready(function () {
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
 });*/
$(document).ready(function () {
    $(".ps-home--links a").eq(0).addClass("active");
    if ($(".ps-block--deposit-filter .ps-form--filter .owl-stage .owl-item").length > 9) {
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").show();
    }
    else {
        $(".ps-block--deposit-filter .ps-form--filter .owl-controls").hide();
    }
    $('.ps-slider--home').on('changed.owl.carousel', function (e) {
        setTimeout(function () {
            var n = $(".ps-slider--home .owl-controls .owl-dots .active").index();
            $(".ps-home--links a").removeClass("active");
            $(".ps-home--links a").eq(n).addClass("active");
        }, 300);

    });
})

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
$('#container').on('click', '.short-list', function () {
    var checked = $(this).is(':checked');
    //$(".checkbox").prop('checked', false);

    if (checked) {
        $(this).prop('checked', true);
        $(".ps-loan-popup").css('display', 'block');
    }
    else {
        $(".ps-loan-popup").css('display', 'none');

    }
    var productIds = [];
    $("input[name='short_list_ids[]']:checked").each(function () {
        productIds.push($(this).val());
    });
    var rateType = $("select[name=rate_type]").val();
    var tenure = $("select[name=tenure]").val();
    var propertyType = $("select[name=property_type]").val();
    var completion = $("select[name=completion]").val();
    var loanAmount = $("input[name=search_value]").val();
    $("input[name=rate_type_search]").val(rateType);
    $("input[name=tenure_search]").val(tenure);
    $("input[name=property_type_search]").val(propertyType);
    $("input[name=completion_search]").val(completion);
    $("input[name=product_ids]").val(productIds);
    $("input[name=loan_amount]").val(loanAmount);
});
$("#loan-enquiry").click(function () {


    $.ajax({
        method: "POST",
        url: APP_URL + "/loan-enquiry",
        data: {
            rate_type: rateType,
            tenure: tenure,
            property_type: propertyType,
            completion: completion,
            product_ids: productIds
        },
        cache: false,
        async: false,
        success: function (data) {
            console.log(data);
            return false;
        }
    });
});

$(document).ready(function () {
    // $("#totop span").html("");
    $(".menu > li.menu-item-has-children").append("<span></span>");
    $("body").on("click", ".menu--mobile > li.menu-item-has-children > span", function (e) {
        e.preventDefault();
        $(".menu--mobile > li > ul ").slideUp();
        if ($(this).parent().hasClass("active")) {
            $(this).parent().removeClass("active");
            $(this).parent().children(".sub-menu").slideUp();
        }
        else {
            $(".menu--mobile > li").removeClass("active");
            $(this).parent().addClass("active");
            $(this).parent().children(".sub-menu").slideDown();
        }
    });
    $("body").on("click", ".ps-block--legend-table .ps-block__header", function () {
        $(this).next().slideToggle();
    });
    $("body").on("click", ".get-in-touch h3", function () {
        $(this).next().slideToggle();
    });
    $(".ps-block--legend-table .ps-block__header").append("<span></span>");

    $(".ps-block--short-product.second.highlight.sp-only").parent().addClass("sp-only");

    if ($(".header__top .header__actions li:last-child").text() == "Logout") {
        $(".header__top p").hide();
    }

    /*$(".ps-page--deposit .ps-product--2 .ps-criteria-detail .ps-block--product-info .ps-block__content .ps-block__more").click(function () {
     var n = $(this).attr("href").replace("#", "");
     $(".ps-page--deposit .ps-product--2 .ps-criteria-detail .ps-criteria-detail__content").css("display", "none");
     $(".ps-criteria-detail__content#" + n).css("display", "block");
     })*/


    //  7/12/2018
    $(".ps-block--short-product img").matchHeight();

    var owl = $('.owl-blog');
    $('.ps-next').click(function () {
        owl.trigger('next.owl.carousel');
    })
    $('.ps-prev').click(function () {
        owl.trigger('prev.owl.carousel', [300]);
    })


    // setTimeout(function () {
    //     $('.ps-slider--home .owl-item').each(function() {
    //         var image_path = $(this).find("img").attr('src');
    //         $(this).css({
    //             'background': 'url(' + image_path + ')'
    //         });
    //     });

    // }, 2000);

    if (screen.width < 768) {
        $("body").on("click", ".ps-wiget--footer h3", function () {
            $(this).next().slideToggle();
        });
        $(".ps-list--sidebar").prepend($(".ps-list--sidebar li.current").clone());
        $(".ps-list--sidebar li:first-child").append("<div><span></span></div>");
        $(".ps-list--sidebar li > div").click(function () {
            if ($(this).parent().hasClass("active")) {
                $(this).parent().removeClass("active");
                $(this).parent().parent().children(".ps-list--sidebar li").slideUp();
            }
            else {
                $(this).parent().addClass("active");
                $(this).parent().parent().children(".ps-list--sidebar li").slideDown();
            }
        });

        $(".ps-product .ps-table-wrap").mCustomScrollbar("destroy");
        $(".ps-post--detail table,.ps-dashboard .ps-table,.ps-product .ps-table-wrap>.ps-table").wrap("<div class='table-responsive'></div>");

    }
    setTimeout(function () {
        $(".owl-slider").each(function () {
            var cf1 = $(this).attr('data-owl-item');
            var cf2 = $(this).find(".owl-item").length;
            if (cf2 > cf1) {
                $(this).find(".owl-nav").addClass("show");
            }
        });
        $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer .owl-stage").addClass("desktop");
        if (screen.width < 768) {
            $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer .owl-stage").removeClass("desktop");
        }
        ;
        /*var bar_x = 0;
         $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-prev").click(function(){
         bar_x = $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer").scrollLeft() - $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer .owl-item").width();
         $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer").scrollLeft(bar_x);
         });
         $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-next").click(function(){
         bar_x = $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer").scrollLeft() + $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer .owl-item").width();
         $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer").scrollLeft(bar_x);
         });*/
    }, 1300);

    $(".ps-page--deposit .ps-slider--feature-product.owl-carousel .owl-stage-outer").scrollLeft();
    /* $(".ps-product .ps-product__heading").each(function(){
     if($(this).find("strong").text() == "UOB Super Saving PROMO:" || $(this).find("strong").text() == ""){
     $(this).parent().find(".ps-table--product th").text().replace("TIER", "");
     }
     });*/
    /*$(".ps-table--product-3 thead tr th .ps-checkbox > label").click(function(){
     setTimeout(function(){pdTableP()},500);
     });*/
});
function pdTableP() {
    $(".ps-product .ps-table-wrap").each(function () {
        $(this).find("p.is-active").appendTo($(this));
    });
}

$(".close-popup").click(function () {
    return false;
})
$(window).on("load", function () {
    $(".ps-product .ps-table-wrap").mCustomScrollbar({
        axis: "x",
        theme: "dark-3"
    });
    /*$(".ps-dashboard .ps-table").mCustomScrollbar({
     axis:"x",
     theme:"dark-3"
     });*/
    $(".table-new").parent().mCustomScrollbar({
        axis: "x",
        theme: "dark-3",
        setLeft: "0px",
    });
    setTimeout(function () {
        $(".ps-product__detail.table .mCSB_horizontal.mCSB_inside>.mCSB_container").css("left", "0px")
    }, 1000);
});
$(window).on('load resize', function () {
    if (screen.width < 768) {
        $(".ps-product .ps-table-wrap").mCustomScrollbar("destroy");
    }
});

