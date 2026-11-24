document.addEventListener('DOMContentLoaded', function () {

  // Hero slider
  var slides = document.querySelectorAll('.hero-slide');
  var dots = document.querySelectorAll('.slider-dot');
  if (slides.length > 1) {
    var current = 0;
    var interval = setInterval(function () {
      slides[current].classList.remove('active');
      if (dots[current]) dots[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
      if (dots[current]) dots[current].classList.add('active');
    }, 5000);

    dots.forEach(function (dot) {
      dot.addEventListener('click', function () {
        var idx = parseInt(dot.getAttribute('data-slide'));
        if (idx === current) return;
        slides[current].classList.remove('active');
        if (dots[current]) dots[current].classList.remove('active');
        current = idx;
        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
        clearInterval(interval);
        interval = setInterval(function () {
          slides[current].classList.remove('active');
          if (dots[current]) dots[current].classList.remove('active');
          current = (current + 1) % slides.length;
          slides[current].classList.add('active');
          if (dots[current]) dots[current].classList.add('active');
        }, 5000);
      });
    });
  }

  // Nav hamburger toggle
  var toggle = document.getElementById('navToggle');
  var links = document.getElementById('navLinks');
  if (toggle && links) {
    toggle.addEventListener('click', function () {
      links.classList.toggle('open');
    });
  }

  // FAQ accordion
  var faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(function (item) {
    var question = item.querySelector('.faq-question');
    if (question) {
      question.addEventListener('click', function () {
        var isOpen = item.classList.contains('open');
        faqItems.forEach(function (i) { i.classList.remove('open'); });
        if (!isOpen) item.classList.add('open');
      });
    }
  });

  // Lightbox
  var lightboxTriggers = document.querySelectorAll('[data-lightbox]');
  var lightbox = document.getElementById('lightbox');
  var lightboxImg = document.getElementById('lightboxImg');
  var lightboxClose = document.getElementById('lightboxClose');

  if (lightboxTriggers.length && lightbox && lightboxImg) {
    lightboxTriggers.forEach(function (el) {
      el.addEventListener('click', function () {
        var src = el.getAttribute('data-lightbox');
        if (src) {
          lightboxImg.src = src;
          lightbox.classList.add('open');
        }
      });
    });

    if (lightboxClose) {
      lightboxClose.addEventListener('click', function () {
        lightbox.classList.remove('open');
      });
    }
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) lightbox.classList.remove('open');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') lightbox.classList.remove('open');
    });
  }

  // Stat counter animation
  var stats = document.querySelectorAll('.stat-value');
  if (stats.length) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var target = parseInt(el.getAttribute('data-target')) || 0;
          var current = 0;
          var increment = Math.ceil(target / 60);
          var timer = setInterval(function () {
            current += increment;
            if (current >= target) {
              el.textContent = target;
              clearInterval(timer);
            } else {
              el.textContent = current;
            }
          }, 20);
          observer.unobserve(el);
        }
      });
    });
    stats.forEach(function (s) { observer.observe(s); });
  }

  // Scroll reveal
  var revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    revealEls.forEach(function (el) { revealObserver.observe(el); });
  }

  // Zdog isometric truss bridge wireframe (procedural, no asset)
  var stage = document.querySelector('.zdog-stage');
  if (stage && window.Zdog) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canvas = document.createElement('canvas');
    canvas.width = 480;
    canvas.height = 420;
    stage.appendChild(canvas);

    var illo = new Zdog.Illustration({
      element: canvas,
      zoom: 2.4,
      dragRotate: true,
      rotate: { x: 0.35, y: 0.7 },
    });

    var COLOR = '#aab8ff';
    var HAIRLINE = 'rgba(170,184,255,0.55)';

    var beam = function (from, to, stroke) {
      return new Zdog.Shape({
        addTo: illo,
        stroke: stroke || 3,
        color: COLOR,
        closed: false,
        path: [from, to],
      });
    };

    // Warren truss panel points (bridge seen from the side)
    var panels = 8;
    var span = 200;      // total width
    var top = -34;       // top chord y
    var bot = 42;        // bottom chord y
    var pts = [];        // top points
    var ptsb = [];       // bottom points
    for (var p = 0; p <= panels; p++) {
      var x = -span / 2 + (span / panels) * p;
      pts.push({ x: x, y: top, z: 0 });
      ptsb.push({ x: x, y: bot, z: 0 });
    }

    // Top & bottom chords
    for (var c = 0; c < panels; c++) {
      beam(pts[c], pts[c + 1], 3);
      beam(ptsb[c], ptsb[c + 1], 3);
    }

    // Warren diagonals (alternating) + vertical posts
    for (var d = 0; d < panels; d++) {
      if (d % 2 === 0) {
        beam(pts[d], ptsb[d + 1], 2.5); // rising diagonal
      } else {
        beam(pts[d + 1], ptsb[d], 2.5); // falling diagonal
      }
      if (d > 0 && d < panels) {
        beam(pts[d], ptsb[d], 2); // vertical post
      }
    }

    // Deck / roadway under the bottom chord
    for (var r = 0; r < 3; r++) {
      beam({ x: -span / 2 - 12, y: bot + 12 + r * 4, z: 0 }, { x: span / 2 + 12, y: bot + 12 + r * 4, z: 0 }, 2);
    }

    // Abutment piers
    beam({ x: -span / 2 - 12, y: bot + 4, z: 0 }, { x: -span / 2 - 12, y: 130, z: 0 }, 4);
    beam({ x: span / 2 + 12, y: bot + 4, z: 0 }, { x: span / 2 + 12, y: 130, z: 0 }, 4);
    beam({ x: -130, y: 130, z: 0 }, { x: 130, y: 130, z: 0 }, 4); // ground line

    // Cable stays / suspension hints (light)
    beam({ x: -span / 2 - 8, y: bot + 14, z: 0 }, { x: 0, y: top - 30, z: 0 }, 1.5);
    beam({ x: span / 2 + 8, y: bot + 14, z: 0 }, { x: 0, y: top - 30, z: 0 }, 1.5);
    beam({ x: 0, y: top - 30, z: 0 }, { x: 0, y: top, z: 0 }, 3);

    var spinning = !reduceMotion;
    illo.onDragStart = function () { spinning = false; };

    var visible = true;
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        visible = entry.isIntersecting;
      });
    }, { threshold: 0 });
    obs.observe(stage);

    function tick() {
      if (visible && spinning) illo.rotate.y += 0.006;
      illo.updateRenderGraph();
      requestAnimationFrame(tick);
    }
    tick();
  }

  });
