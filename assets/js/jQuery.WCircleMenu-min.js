(function (x) {
  x.fn.WCircleMenu = function (N) {
    if (N == "open") {
      this.trigger("WCircleMenuOpen");
      return;
    }
    if (N == "close") {
      this.trigger("WCircleMenuClose");
      return;
    }
    var P = x.extend({}, x.fn.WCircleMenu.defaults, N);
    P.easingFuncShow = a(P.easingFuncShow);
    P.easingFuncHide = a(P.easingFuncHide);
    this.children("div.wcircle-icon").css({
      position: "absolute",
      top: 0,
      height: 0,
      width: P.width,
      height: P.height,
      display: "block",
    });
    this.children("div.wcircle-menu")
      .css({
        width: P.width,
        height: P.height,
        position: "relative",
        display: "none",
      })
      .children("div")
      .css({ position: "absolute", top: "0", left: "0", opacity: "0" });
    function O(S) {
      if (S.is(".wcircle-open")) {
        return;
      }
      var R = S.children("div.wcircle-menu");
      R.show();
      var T = R.children("div");
      p({
        objek: R.prev(),
        targetX: 0,
        fromX: 0,
        targetY: 0,
        fromY: 0,
        targetO: 1,
        fromO: 1,
        targetRot: P.iconRotation,
        fromRot: 0,
        easingFunc: P.easingFuncShow,
        step: P.step,
      });
      for (var Q = 0; Q < T.length; Q++) {
        (function (U) {
          var V = false;
          if (U == T.length - 1) {
            V = function () {
              S.removeClass("wcircle-animating");
              S.addClass("wcircle-open");
              if (typeof P.openCallback == "function") {
                P.openCallback();
              }
            };
          }
          setTimeout(function () {
            p({
              objek: T.eq(U),
              targetX: Math.round(
                Math.cos(P.angle_interval * U + P.angle_start) * P.distance
              ),
              fromX: 0,
              targetY: Math.round(
                Math.sin(P.angle_interval * U + P.angle_start) * P.distance
              ),
              fromY: 0,
              targetO: 1,
              fromO: 0,
              targetRot: 0,
              fromRot: P.itemRotation,
              easingFunc: P.easingFuncShow,
              step: P.step,
              callback: V,
            });
          }, P.delay * U);
        })(Q);
      }
    }
    function M(S) {
      if (!S.is(".wcircle-open")) {
        return;
      }
      var R = S.children("div.wcircle-menu");
      var T = R.children("div");
      p({
        objek: R.prev(),
        targetX: 0,
        fromX: 0,
        targetY: 0,
        fromY: 0,
        targetO: 1,
        fromO: 1,
        targetRot: 0,
        fromRot: P.iconRotation,
        easingFunc: P.easingFuncHide,
        step: P.step,
      });
      for (var Q = T.length - 1; Q >= 0; Q--) {
        (function (U) {
          var V = false;
          if (U == 0) {
            V = function () {
              R.hide();
              S.removeClass("wcircle-animating");
              S.removeClass("wcircle-open");
              if (typeof P.closeCallback == "function") {
                P.closeCallback();
              }
            };
          }
          setTimeout(function () {
            p({
              objek: T.eq(U),
              targetX: 0,
              fromX: Math.round(
                Math.cos(P.angle_interval * U + P.angle_start) * P.distance
              ),
              targetY: 0,
              fromY: Math.round(
                Math.sin(P.angle_interval * U + P.angle_start) * P.distance
              ),
              targetO: 0,
              fromO: 1,
              targetRot: P.itemRotation,
              fromRot: 0,
              easingFunc: P.easingFuncHide,
              step: P.step,
              callback: V,
            });
          }, P.delay * (T.length - (U + 1)));
        })(Q);
      }
    }
    this.off("WCircleMenuOpen").on("WCircleMenuOpen", function () {
      self = x(this);
      O(self);
    });
    this.off("WCircleMenuClose").on("WCircleMenuClose", function () {
      self = x(this);
      M(self);
    });
    return this.off("click").on("click", function (S) {
      var Q = x(this);
      if (Q.is(".wcircle-animating")) {
        return;
      }
      Q.addClass("wcircle-animating");
      var R = Q.children("div.wcircle-menu");
      if (R.is(":visible")) {
        M(Q);
      } else {
        O(Q);
      }
    });
  };
  x.fn.WCircleMenu.defaults = {
    width: "50px",
    height: "50px",
    angle_start: -Math.PI / 2,
    delay: 50,
    distance: 100,
    angle_interval: Math.PI / 6,
    easingFuncShow: "easeOutBack",
    easingFuncHide: "easeInBack",
    step: 15,
    openCallback: false,
    closeCallback: false,
    itemRotation: 360,
    iconRotation: 180,
  };
  function p(R) {
    if (typeof R.objek == "undefined") {
      return false;
    }
    var M = R.objek instanceof jQuery ? R.objek : x(R.objek);
    if (M.is(".animatingTranslateXYO")) {
      return false;
    }
    var X = typeof R.targetX == "undefined" ? false : R.targetX;
    var Y = typeof R.fromX == "undefined" ? false : R.fromX;
    var V = typeof R.targetY == "undefined" ? false : R.targetY;
    var W = typeof R.fromY == "undefined" ? false : R.fromY;
    var N = typeof R.targetO == "undefined" ? false : R.targetO;
    var O = typeof R.fromO == "undefined" ? false : R.fromO;
    var S = typeof R.targetRot == "undefined" ? false : R.targetRot;
    var T = typeof R.fromRot == "undefined" ? false : R.fromRot;
    var Z = typeof R.callback == "undefined" ? false : R.callback;
    var Q = typeof R.easingFunc != "function" ? d : R.easingFunc;
    var P = typeof R.step == "undefined" ? 15 : R.step;
    var U = "transform";
    ["webkit", "Moz", "O", "ms"].every(function (aa) {
      var ab = aa + "Transform";
      if (typeof document.body.style[ab] !== "undefined") {
        U = ab;
      }
    });
    M.addClass("animatingTranslateXYO");
    F(M, X, Y, V, W, N, O, S, T, P, 0, Z, Q, U);
  }
  function F(ae, V, X, U, W, aa, ab, Q, ad, S, T, P, N, M) {
    if (ae.is(".animatingTranslateXYO")) {
      if (typeof X === "undefined" || X === false) {
        X = parseInt(s(ae[0]));
      }
      if (typeof V === "undefined" || V === false) {
        V = X;
      }
      if (typeof W === "undefined" || W === false) {
        W = parseInt(r(ae[0]));
      }
      if (typeof U === "undefined" || U === false) {
        U = W;
      }
      if (typeof ab === "undefined" || ab === false) {
        ab = parseFloat(l(ae[0]));
      }
      if (typeof aa === "undefined" || aa === false) {
        aa = ab;
      }
      if (typeof ad === "undefined" || ad === false) {
        ad = 0;
      }
      if (typeof Q === "undefined" || Q === false) {
        Q = ad;
      }
      var O = {};
      if (T <= S) {
        var Z = N(T, X, V - X, S);
        var Y = N(T, W, U - W, S);
        var ac = N(T, ab, aa - ab, S);
        var R = N(T, ad, Q - ad, S);
        O[M] = "translate3d(" + Z + "px, " + Y + "px, 0)rotate(" + R + "deg)";
        O.opacity = ac;
        T = T + 1;
        window.requestAnimationFrame(function () {
          F(ae, V, X, U, W, aa, ab, Q, ad, S, T, P, N, M);
        });
        ae.css(O);
      } else {
        O[M] = "translate3d(" + V + "px, " + U + "px, 0)rotate(" + Q + "deg)";
        O.opacity = aa;
        ae.css(O);
        ae.removeClass("animatingTranslateXYO");
        if (typeof P == "function") {
          P();
        }
      }
    }
  }
  function s(N) {
    var M = new WebKitCSSMatrix(
      window.getComputedStyle(N, null).webkitTransform
    );
    return M.m41;
  }
  function r(N) {
    var M = new WebKitCSSMatrix(
      window.getComputedStyle(N, null).webkitTransform
    );
    return M.m42;
  }
  function l(M) {
    return window.getComputedStyle(M).opacity;
  }
  function a(M) {
    switch (M) {
      case "linearEase":
        return o;
      case "easeInQuad":
        return e;
      case "easeOutQuad":
        return L;
      case "easeInOutQuad":
        return C;
      case "easeInCubic":
        return f;
      case "easeOutCubic":
        return b;
      case "easeInOutCubic":
        return g;
      case "easeInQuart":
        return m;
      case "easeOutQuart":
        return j;
      case "easeInOutQuart":
        return n;
      case "easeInQuint":
        return y;
      case "easeOutQuint":
        return w;
      case "easeInOutQuint":
        return z;
      case "easeInSine":
        return c;
      case "easeOutSine":
        return J;
      case "easeInOutSine":
        return B;
      case "easeInExpo":
        return E;
      case "easeOutExpo":
        return A;
      case "easeInOutExpo":
        return t;
      case "easeInCirc":
        return i;
      case "easeOutCirc":
        return d;
      case "easeInOutCirc":
        return H;
      case "easeInElastic":
        return D;
      case "easeOutElastic":
        return G;
      case "easeInOutElastic":
        return v;
      case "easeInBack":
        return u;
      case "easeOutBack":
        return q;
      case "easeInOutBack":
        return h;
      case "easeInBounce":
        return k;
      case "easeOutBounce":
        return I;
      case "easeInOutBounce":
        return K;
        defaults: {
          return false;
        }
    }
  }
  function o(N, M, P, O) {
    return (P * N) / O + M;
  }
  function e(N, M, P, O) {
    return P * (N /= O) * N + M;
  }
  function L(N, M, P, O) {
    return -P * (N /= O) * (N - 2) + M;
  }
  function C(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * N * N + M;
    }
    return (-P / 2) * (--N * (N - 2) - 1) + M;
  }
  function f(N, M, P, O) {
    return P * Math.pow(N / O, 3) + M;
  }
  function b(N, M, P, O) {
    return P * (Math.pow(N / O - 1, 3) + 1) + M;
  }
  function g(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * Math.pow(N, 3) + M;
    }
    return (P / 2) * (Math.pow(N - 2, 3) + 2) + M;
  }
  function m(N, M, P, O) {
    return P * Math.pow(N / O, 4) + M;
  }
  function j(N, M, P, O) {
    return -P * (Math.pow(N / O - 1, 4) - 1) + M;
  }
  function n(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * Math.pow(N, 4) + M;
    }
    return (-P / 2) * (Math.pow(N - 2, 4) - 2) + M;
  }
  function y(N, M, P, O) {
    return P * Math.pow(N / O, 5) + M;
  }
  function w(N, M, P, O) {
    return P * (Math.pow(N / O - 1, 5) + 1) + M;
  }
  function z(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * Math.pow(N, 5) + M;
    }
    return (P / 2) * (Math.pow(N - 2, 5) + 2) + M;
  }
  function c(N, M, P, O) {
    return P * (1 - Math.cos((N / O) * (Math.PI / 2))) + M;
  }
  function J(N, M, P, O) {
    return P * Math.sin((N / O) * (Math.PI / 2)) + M;
  }
  function B(N, M, P, O) {
    return (P / 2) * (1 - Math.cos((Math.PI * N) / O)) + M;
  }
  function E(N, M, P, O) {
    return P * Math.pow(2, 10 * (N / O - 1)) + M;
  }
  function A(N, M, P, O) {
    return P * (-Math.pow(2, (-10 * N) / O) + 1) + M;
  }
  function t(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * Math.pow(2, 10 * (N - 1)) + M;
    }
    return (P / 2) * (-Math.pow(2, -10 * --N) + 2) + M;
  }
  function i(N, M, P, O) {
    return P * (1 - Math.sqrt(1 - (N /= O) * N)) + M;
  }
  function d(N, M, P, O) {
    return P * Math.sqrt(1 - (N = N / O - 1) * N) + M;
  }
  function H(N, M, P, O) {
    if ((N /= O / 2) < 1) {
      return (P / 2) * (1 - Math.sqrt(1 - N * N)) + M;
    }
    return (P / 2) * (Math.sqrt(1 - (N -= 2) * N) + 1) + M;
  }
  function D(O, M, S, R) {
    var P = 1.70158,
      Q = 0,
      N = S;
    if (S == 0) {
      return M;
    }
    if (O == 0) {
      return M;
    }
    if ((O /= R) == 1) {
      return M + S;
    }
    if (!Q) {
      Q = R * 0.3;
    }
    if (N < Math.abs(S)) {
      N = S;
      P = Q / 4;
    } else {
      P = (Q / (2 * Math.PI)) * Math.asin(S / N);
    }
    return (
      -(
        N *
        Math.pow(2, 10 * (O -= 1)) *
        Math.sin(((O * R - P) * (2 * Math.PI)) / Q)
      ) + M
    );
  }
  function G(O, M, S, R) {
    var P = 1.70158,
      Q = 0,
      N = S;
    if (S == 0) {
      return M;
    }
    if (O == 0) {
      return M;
    }
    if ((O /= R) == 1) {
      return M + S;
    }
    if (!Q) {
      Q = R * 0.3;
    }
    if (N < Math.abs(S)) {
      N = S;
      P = Q / 4;
    } else {
      P = (Q / (2 * Math.PI)) * Math.asin(S / N);
    }
    return (
      N * Math.pow(2, -10 * O) * Math.sin(((O * R - P) * (2 * Math.PI)) / Q) +
      S +
      M
    );
  }
  function v(O, M, S, R) {
    var P = 1.70158,
      Q = 0,
      N = S;
    if (S == 0) {
      return M;
    }
    if (O == 0) {
      return M;
    }
    if ((O /= R / 2) == 2) {
      return M + S;
    }
    if (!Q) {
      Q = R * (0.3 * 1.5);
    }
    if (N < Math.abs(S)) {
      N = S;
      P = Q / 4;
    } else {
      P = (Q / (2 * Math.PI)) * Math.asin(S / N);
    }
    if (O < 1) {
      return (
        -0.5 *
          (N *
            Math.pow(2, 10 * (O -= 1)) *
            Math.sin(((O * R - P) * (2 * Math.PI)) / Q)) +
        M
      );
    }
    return (
      N *
        Math.pow(2, -10 * (O -= 1)) *
        Math.sin(((O * R - P) * (2 * Math.PI)) / Q) *
        0.5 +
      S +
      M
    );
  }
  function u(N, M, R, P, Q) {
    var O = typeof Q == "undefined" ? 1.70158 : Q;
    return R * (N /= P) * N * ((O + 1) * N - O) + M;
  }
  function q(N, M, R, P, Q) {
    var O = typeof Q == "undefined" ? 1.70158 : Q;
    return R * ((N = N / P - 1) * N * ((O + 1) * N + O) + 1) + M;
  }
  function h(N, M, R, P, Q) {
    var O = typeof Q == "undefined" ? 1.70158 : Q;
    if ((N /= P / 2) < 1) {
      return (R / 2) * (R * R * (((O *= 1.525) + 1) * N)) + M;
    }
    return (R / 2) * ((N -= 2) * N * (((O *= 1.525) + 1) * N + O) + 2) + M;
  }
  function k(N, M, P, O) {
    return P - easing.easeOutBounce(O - N, 0, P, O) + M;
  }
  function I(N, M, P, O) {
    if ((N /= O) < 1 / 2.75) {
      return P * (7.5625 * N * N) + M;
    } else {
      if (N < 2 / 2.75) {
        return P * (7.5625 * (N -= 1.5 / 2.75) * N + 0.75) + M;
      } else {
        if (N < 2.5 / 2.75) {
          return P * (7.5625 * (N -= 2.25 / 2.75) * N + 0.9375) + M;
        } else {
          return P * (7.5625 * (N -= 2.625 / 2.75) * N + 0.984375) + M;
        }
      }
    }
  }
  function K(N, M, P, O) {
    if (N < O / 2) {
      return easing.easeOutBounce(N * 2, 0, P, O) * 0.5 + M;
    } else {
      return easing.easeOutBounce(N * 2 - O, 0, P, O) * 0.5 + P * 0.5 + M;
    }
  }
})(jQuery);
