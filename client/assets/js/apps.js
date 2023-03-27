/* Menu */
$(document).ready(function () {
  /* Menu remove empty ul */
  if (isExist($(".menu"))) {
    $(".menu ul li a").each(function () {
      $this = $(this);
      if (!isExist($this.next("ul").find("li"))) {
        $this.next("ul").remove();
        $this.removeClass("has-child");
      }
    });
  }

  /* Mmenu */
  if (isExist($("nav#menu"))) {
    $("nav#menu").mmenu({
      extensions: ["border-full", "position-left", "position-front"],
    });
  }
});

/* Fix menu */
$(document).ready(function () {
  $(window).scroll(function () {
    if ($(window).width() > 991) {
      if (
        $(window).scrollTop() >=
        $(".header").height() + $(".slideshow").height()
      ) {
        $(".menu").addClass("fixed animate__fadeInDown animate__animated");
        $(".ul-menu").addClass("hidden-menu");
        $(".header").css({ "margin-bottom": $(".menu").height() });
      } else {
        $(".menu").removeClass("fixed animate__fadeInDown animate__animated");
        $(".header").css({ "margin-bottom": "" });
        if (isExist($(".wrap-home"))) {
          $(".ul-menu").removeClass("hidden-menu");
        }
      }
    } else {
      if ($(window).scrollTop() >= $(".header").height()) {
        $(".menu-res").addClass("fixed animate__fadeInDown animate__animated");

        $(".header").css({ "margin-bottom": $(".menu-res").height() });
      } else {
        $(".menu-res").removeClass(
          "fixed animate__fadeInDown animate__animated"
        );

        $(".header").css({ "margin-bottom": "" });
      }
    }
  });

  $(".menu-left .title").click(function () {
    if ($(".ul-menu").hasClass("hidden-menu")) {
      $(".ul-menu").removeClass("hidden-menu");
    } else {
      $(".ul-menu").addClass("hidden-menu");
    }
  });

  $(window).bind("load resize", function () {
    if (isExist($(".slideshow"))) {
      heigth = $(".slideshow").height();
    } else {
      heigth = 350;
    }

    $(".ul-menu").height(heigth);
  });
});

/* Search */
$(document).ready(function () {
  if (isExist($(".icon-search"))) {
    $(".icon-search").click(function () {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(".search-grid")
          .stop(true, true)
          .animate({ opacity: "0", width: "0px" }, 200);
      } else {
        $(this).addClass("active");
        $(".search-grid")
          .stop(true, true)
          .animate({ opacity: "1", width: "230px" }, 200);
      }
      document.getElementById($(this).next().find("input").attr("id")).focus();
      $(".icon-search i").toggleClass("fa fa-search fa fa-times");
    });
  }
});

/* Carousel */
$(document).ready(function () {
  $(".slideshow__slider").owlCarousel({
    loop: false,
    margin: 10,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
  });

  $(".categories__slider").owlCarousel({
    loop: false,
    margin: 20,
    items: 4,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
      },

      480: {
        items: 2,
      },

      768: {
        items: 3,
      },

      992: {
        items: 4,
      },
    },
  });

  $(".newsnb__owl").owlCarousel({
    loop: false,
    margin: 30,
    items: 3,
    dots: false,
    nav: true,
    navText: [
      "<span class='fa fa-angle-left'><span/>",
      "<span class='fa fa-angle-right'><span/>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
      },

      480: {
        items: 2,
      },

      768: {
        items: 3,
      },

      992: {
        items: 3,
      },
    },
  });
});

$(document).ready(function () {
  $(".set-bg").each(function () {
    var bg = $(this).data("setbg");
    $(this).css("background-image", "url(" + bg + ")");
  });
});

$(document).ready(function () {
  loadPaging("api/product.php?perpage=8", ".paging-product-list", 0);
  $(".title-product-list .a-title-product").click(function () {
    $(".title-product-list .a-title-product").removeClass("active");
    $(this).addClass("active");
    var _list = $(this).data("list");
    loadPaging(
      "api/product.php?idList=" + _list + "&perpage=8",
      ".paging-product-list",
      0
    );
  });
});

$(document).ready(function () {
  if (isExist($("[data-margin]"))) {
    $("[data-margin]").each(function () {
      var $margin = $(this).data("margin");
      $(this).css({ "margin-bottom": $margin + "px" });
    });
  }

  if (isExist($("[data-padding]"))) {
    $("[data-padding]").each(function () {
      var $padding = $(this).data("padding");
      $(this).css({ "padding-top": $padding + "px" });
      $(this).css({ "padding-bottom": $padding + "px" });
    });
  }

  if (isExist($("[data-row]"))) {
    $("[data-row]").each(function () {
      var $padding = $(this).data("row");

      $this.children('[class*="col"]').css({
        paddingLeft: $padding + "px",
        paddingRight: $padding + "px",
      });

      $this.css({
        marginLeft: -$padding + "px",
        marginRight: -$padding + "px",
      });
    });
  }
});
