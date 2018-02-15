(function ($) {

  if (typeof Drupal != 'undefined') {
    Drupal.behaviors.projectName = {
      attach: function (context, settings) {
        init();
      },

      completedCallback: function () {
        // Do nothing. But it's here in case other modules/themes want to override it.
      }
    }
  }

  $(function () {
    if (typeof Drupal == 'undefined') {
      init();
    }
  });

  $(window).load(function() {
    initDot();
  });

  function init() {
    initFormQuote();
    initSelect();
    initTabs();
    initFlexslider();
    initColumnizer();
    initcollapsibleBlock();
    initMobileNav();
    initElmsAnimation();
    initScrollMagic();
    initScrollTo();
    initSearchForm();
  }

  function  initSearchForm() {
    var $wrap = $('.site-header');
    var $btnSearch = $wrap.find('.btn-search');

    if (!$btnSearch.length ) return;

    var $btnSearchClose = $wrap.find('.search-wrap .btn-close');

    $btnSearchClose.on('click touch', function(e){
      e.preventDefault();

      $wrap.removeClass('search-open');
    });

    $btnSearch.on('click touch', function(e){
      e.preventDefault();

      $wrap.addClass('search-open');
    });
  }

  function initScrollTo() {
    var $controlNav = $('.control .navigation');

    if (!$controlNav.length) return;

    var $btnsNav = $controlNav.find('a');

    $btnsNav.on('click touch', function(e){
      e.preventDefault();
      $('html, body').animate({scrollTop: $('a[name="'+this.hash.slice(1)+'"]'
      ).offset().top - 20}, 800);
    });
  }

  function initScrollMagic() {
    if (document.documentElement.classList.contains('tablet') ||
      document.documentElement.classList.contains('mobile') ||
      document.documentElement.classList.contains('parallax-processed')) {

      return;
    }
    document.documentElement.classList.add('parallax-processed');

    var parallaxItems = document.querySelectorAll('.section-top');
    if (!parallaxItems.length) return;

    var divImg= [];
    var controller = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "1"}});

    for (var i = 0; i < parallaxItems.length; i++) {
        var currentDivImg = parallaxItems[i].querySelectorAll(".bg");

      if (!currentDivImg.length) continue;

      for(var y = 0; y < currentDivImg.length; y++) {
        newScene(parallaxItems[i], currentDivImg[y]);
      }
    }

    window.addEventListener('resize', function() {
      for (var i = 0; i < divImg.length; i++) {
        divImg[i][1].duration(window.innerHeight + divImg[i][0].offsetHeight);
      }
    });

    function newScene(item, currentImage) {
      divImg.push([item, new ScrollMagic.Scene({triggerElement: item, duration: window.innerHeight + item.offsetHeight})
        .setTween(currentImage, {y: "300", ease: Linear.easeNone})
        .addTo(controller)]);
    }
  }

  function initElmsAnimation() {
    window.sr = ScrollReveal({
      duration: 1000,
      scale: 1,
      easing: 'ease',
      origin: 'left',
      mobile: false
    });

    sr.reveal('.section-nav .nav-wrap .ico', {
      duration: 1000,
      distance: '30px'
    }, 250 );

    sr.reveal('.section-nav .nav-wrap.style-b li a', {
      duration: 1000,
      distance: '30px'
    }, 250 );

    sr.reveal('.section-news .item', {
      distance: '150px',
      origin: 'bottom'
    }, 500 );

    $('.b-team .item').each( function(){

     sr.reveal($(this).find('.img-staff'), {
        duration: 1300,
        distance: '50px'
      }, 100);
    });
  }

  function initMobileNav() {
    var $navWrapper = $('.nav');

    if(!$navWrapper.length) return;

    var $btn = $navWrapper.find('.btn-nav');

    $btn.on('click touch', checkNav);

    $('html').on('click touch', function (e) {
      if (!$(e.target).closest($navWrapper).length && $navWrapper.hasClass('nav-active')) {
        $navWrapper.removeClass('nav-active');
      }
    });

    function checkNav(e) {
      e.preventDefault();
      $navWrapper.toggleClass('nav-active');
    }
  }

  function initcollapsibleBlock() {
    var $collapsibleBlock = $('.b-collapsible');

    if (!$collapsibleBlock.length) return;

    $collapsibleBlock.find('.btn-collapse').on('click touch', function(e) {
      e.preventDefault();

      var $thisItems = $(this).closest('.item');

      $thisItems.toggleClass('collapsed');
      $thisItems.find('.item-content').slideToggle(500);
    })
  }

  function  initDot() {
    var $item = $('.section-news .item');

    if (!$item.length) return;

    var $win = $(window);

    dot();

    $item.find('.preview').dotdotdot({
        watch		: true
      }
    );

    $win.on('resize', dot);

    function dot() {

      $item.each( function(){
        var $this =  $(this);
        var $prev = $this.find('.preview');
        var $title = $this.find('.title h3');

        if (($title.outerHeight(true) > 86) && (!$prev.hasClass('no-img'))) {
          $this.addClass('preview-hidden');
          var $img = $this.find('.img');
          var $elHeight = $img.siblings().not('.preview');
          var sumHeight = 0;

          $elHeight.each( function(){
            sumHeight += $(this).outerHeight(true);
          });

          $img.find('img').css('max-height', ($this.height() - sumHeight) + 'px');

        } else {
          $this.removeClass('preview-hidden');
          var $img = $this.find('.img img');
          if($img.length) {
            $img.attr('style', '');
          }
          var $elHeight = $prev.siblings();
          var sumHeight = 0;

          $elHeight.each( function(){
            sumHeight += $(this).outerHeight(true);
          });

          var prevMargin = parseInt($prev.css('margin-top')) + parseInt($prev.css('margin-bottom'));
          $prev.height($this.height() - sumHeight - prevMargin);
        }
      });
    }
  }

  function initColumnizer() {
    var $el = $('.section-tabs .item .columnizer');

    if(!$el.hasClass('processed')) {
      $el.addClass('processed');

      $el.columnize({
        columns: 2
      });
    }
  }

  function initFormQuote() {
    var $wrapper = $('.form-quote');

    if(!$wrapper.length) return;

    var $fieldAssociation = $wrapper.find('[value=association]');
    var $fieldAssociationInput = $wrapper.find('.webform-component--association-name');
    var $fieldAssociationWrapper = $fieldAssociation.parent();
    $fieldAssociationWrapper.width(370);
    $fieldAssociationWrapper.append($fieldAssociationInput);

    var $fieldReferred = $wrapper.find('[value=referred_by]');
    var $fieldReferredInput = $wrapper.find('.webform-component--persons-name');
    var $fieldReferredWrapper = $fieldReferred.parent();
    $fieldReferredWrapper.width(374);
    $fieldReferredWrapper.append($fieldReferredInput);
  }

  function initSelect() {
    $('select').select2({
      width: 'full',
      minimumResultsForSearch: Infinity
    });
  }

  function initFlexslider() {
    var $sectionTeamSlider = $('.section-team');

    $('.flexslider').flexslider({
      pauseOnHover: true,
      start: function(slider) {
        if($sectionTeamSlider.length) {
          var $customNav = $sectionTeamSlider.find('.left-part').prepend('<ul class="custom-nav">' +
            '<li><a class="prev" href="#"></a></li>' +
            '<li class="current"></li>' +
            '<li>/</li>' +
            '<li class="count"></li>' +
            '<li><a class="next" href="#"></a></li>' +
            '</ul>' +
            '<div class="information"></div>');

          $customNav.find('.count').text(slider.count);

          var $prev = $customNav.find('.prev');
          var $next = $customNav.find('.next');

          $prev.on('click', function(e) {
            e.preventDefault();

            if($(this).hasClass('disabled')) return;

            $sectionTeamSlider.find('.flex-prev').trigger('click');
          });

          $next.on('click', function(e) {
            e.preventDefault();

            if($(this).hasClass('disabled')) return;

            $sectionTeamSlider.find('.flex-next').trigger('click');
          });

          current(slider);
        }
      },
      after: function(slider) {
        if($sectionTeamSlider.length) {
          current(slider);
        }
      }
    });

    function current(slider) {
      var $customNav = $sectionTeamSlider.find('.custom-nav');
      var $info = $sectionTeamSlider.find('.information');
      var $current = $customNav.find('.current');
      var $prev = $customNav.find('.prev');
      var $next = $customNav.find('.next');

      $current.text(slider.currentSlide + 1);
      $info.html($(slider).find('.slides > li.flex-active-slide .hidden').clone());

      if(slider.currentSlide == 0) {
        $prev.addClass('disabled');
      } else if($prev.hasClass('disabled')) {
        $prev.removeClass('disabled');
      }

      if(slider.currentSlide == slider.count - 1) {
        $next.addClass('disabled');
      } else if($next.hasClass('disabled')) {
        $next.removeClass('disabled');
      }
    }
  }

  function initTabs() {
    var $wrapper = $('.section-tabs');

    if(!$wrapper.length) return;

    var $nav = $wrapper.find('.tabs-nav li');
    var $content = $wrapper.find('.tabs-content .item');
    var prefixNav = 'tab-';
    var prefixEl = 'tab-c-';
    var current;

    for(var i = 0; i < $nav.length; i++) {
      var link = $nav.eq(i).find('a');
      var href = link.text().trim().replace(/\s/g, '-').toLocaleLowerCase();

      link.attr('href', '#' + prefixNav + href);
      $content.eq(i).attr('id', prefixEl + href);
    }

    if(window.location.hash && ~window.location.hash.indexOf(prefixNav)) {
      isHash();

      $(window).on('load', function() {
        $('html, body').animate({
          scrollTop: $wrapper.offset().top + 20
        }, 600);
      });
    } else {
      setActive(0);
    }

    $(window).on('hashchange', function() {
      isHash();
    });

    function isHash() {
      if(!~window.location.hash.indexOf(prefixNav)) return;

      var $el = $('#' + prefixEl + window.location.hash.replace('#' + prefixNav, ''));

      if($el.length) {
        setActive($el.index());
      }
    }

    function setActive(index) {
      if(index == current) return;

      current = index;

      $nav.removeClass('active').eq(current).addClass('active');
      $content.removeClass('active').eq(current).addClass('active');
    }
  }

  window.removeMarketoDefaultStyles = function(form) {
    form.removeAttr('style');
    form.find('.mktoFormRow').addClass('form-item');
    form.find('.mktoButtonRow').removeClass('mktoButtonRow').addClass('form-actions');
    form.find('button').addClass('form-submit');
    form.find('input, textarea, label, .mktoFormCol, .mktoButtonWrap, .mktoRequired').removeAttr('style');
    form.find('.mktoOffset, .mktoGutter, .mktoClear, .mktoLabel').remove();
    form.removeClass('mktoForm').addClass('mktoFormWithoutStyles');
  };

  window.changeMarketoDefaultBtnText = function(form, text) {
    form.find('button').text(text);
  };

  window.addTextBeforeBtn = function(form, text) {
    form.find('button').before('<div class="text-before-btn">' + text + '</div>')
  };

  window.successMessage = function(form, text) {
    form.hide();
    form.after('<div class="success-message">' + text + '</div>')
  };

})(jQuery);