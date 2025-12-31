//body preloader
$(window).on('load', function () {
  setTimeout(function () { // allowing 3 secs to fade out loader
    $('.page-loader').fadeOut('slow');
  }, 3500);
});
// On Scroll Header fixed to top
$(window).scroll(function () {
  if ($(window).scrollTop() >= 50) {
    $('header').addClass('fixed-top smooth');
  }
  else {
    $('header').removeClass('fixed-top smooth');
  }
});

// On hover open dropdown menu & clickable parent link
jQuery(function ($) {
  if ($(window).width() > 320) {
    $('.navbar .dropdown').hover(function () {
      $(this).find('.dropdown-menu').first().stop(true, true).delay(20).slideDown();

    }, function () {
      $(this).find('.dropdown-menu').first().stop(true, true).delay(20).slideUp();

    });

    $('.navbar .dropdown > a').click(function () {
      location.href = this.href;
    });

  }
});

//menu toggel
$('.menu-toggle').on('click', function () {
  $('.btn-wrapper').toggleClass('menu--is-revealed');
});

// menu link click close collapse
$('.navbar-collapse a').click(function () {
  $(".navbar-collapse").collapse('hide');
  $(".btn-wrapper").toggleClass('menu--is-revealed');
});
// On Scroll back to top
$(window).on('scroll', function () {

  // Back Top Button
  if ($(window).scrollTop() > 500) {
    $('.scrollup').addClass('back-top');
  } else {
    $('.scrollup').removeClass('back-top');
  }
});
// On Click Section Switch
// used for back-top
$('[data-type="section-switch"]').on('click', function () {
  if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
    var target = $(this.hash);
    if (target.length > 0) {

      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      $('html,body').animate({
        scrollTop: target.offset().top
      }, 1000);
      return false;
    }
  }
});

// countdown js
setInterval(function time() {
  var d = new Date();
  var hours = 24 - d.getHours();
  var min = 60 - d.getMinutes();
  if ((min + '').length == 1) {
    min = '0' + min;
  }
  var sec = 60 - d.getSeconds();
  if ((sec + '').length == 1) {
    sec = '0' + sec;
  }
  jQuery('.the-final-countdown .timer').html(hours + ':' + min + ':' + sec)
}, 1000);

//partner slider
$('#carouselfeatures').owlCarousel({
  loop: true,
  margin: 30,
  autoplay: true,
  autoplayTimeout: 3000,
  autoplayHoverPause: true,
  nav: true,
  dots: false,
  navText: ["<i class='bi bi-arrow-left-short'></i>", "<i class='bi bi-arrow-right-short'></i>"],
  responsiveClass: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 4
    }
  }
});

//counter function
var a = 0;
$(window).scroll(function () {

  var oTop = $('#counter').offset().top - window.innerHeight;
  if (a == 0 && $(window).scrollTop() > oTop) {
    $('.counter-value').each(function () {
      var $this = $(this),
        countTo = $this.attr('data-count');
      $({
        countNum: $this.text()
      }).animate({
        countNum: countTo
      },

        {

          duration: 8000,
          easing: 'swing',
          step: function () {
            $this.text(Math.floor(this.countNum));
          },
          complete: function () {
            $this.text(this.countNum);
            //alert('finished');
          }

        });
    });
    a = 1;
  }
});

//review slider
$('#carouselReview').owlCarousel({
  loop: false,
  margin: 30,
  nav: true,
  dots: false,
  items: 2,
  navText: ["<i class='bi bi-arrow-left-short'></i>", "<i class='bi bi-arrow-right-short'></i>"],
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    1000: {
      items: 2
    }
  }
});

// hero pic effect
const bg = document.querySelector('.hero-image');
const windowWidth = window.innerWidth / 5;
const windowHeight = window.innerHeight / 5;

bg.addEventListener('mousemove', (e) => {
  const mouseX = e.clientX / windowWidth;
  const mouseY = e.clientY / windowHeight;

  bg.style.transform = `translate3d(-${mouseX}%, -${mouseY}%, 0)`;
});

// aos animation
AOS.init();

// video frame open popup
jQuery(document).ready(function ($) {
  // Define App Namespace
  var popup = {
    // Initializer
    init: function () {
      popup.popupVideo();
    },
    popupVideo: function () {

      $('.video_model').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        gallery: {
          enabled: true
        }
      });

      // Image Gallery Popup
      $('.gallery_container').magnificPopup({
        delegate: 'a',
        type: 'image',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        gallery: {
          enabled: true
        }
      });

    }
  };
  popup.init($);
});