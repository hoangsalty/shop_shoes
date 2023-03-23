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

  $(".xdvt").hover(function () {
    var vitri = $(this).position().top - 1;
    $(".xdvt>ul").css({ top: vitri + "px" });
  });
  $(".xdvt2").hover(function () {
    var vitri = $(this).position().top - 1;

    $(".xdvt2>ul").css({ top: vitri + "px" });
  });
  $(".xdvt3").hover(function () {
    var vitri = $(this).position().top - 1;
    $(".xdvt3>ul").css({ top: vitri + "px" });
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
      heigth = $(".slideshow").height() - 20;
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
  $(".categories__slider").owlCarousel({
    loop: true,
    margin: 20,
    items: 4,
    dots: false,
    nav: true,
    navText: [
      "<i class='fa-solid fa-angle-left'></i>",
      "<i class='fa-solid fa-angle-right'></i>",
    ],
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: false,
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
