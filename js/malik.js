// as the page loads, call these scripts
jQuery(document).ready(function($) {

  (function( $ ) {

    "use strict";

    /* Get viewport width */
    var responsive_viewport = $(window).width();

    let siteTop = 0;
    const alignWideBlocks = document.querySelectorAll('.alignwide');
    const alignFullBlocks = document.querySelectorAll('.alignfull');
    const coverImageBlocks = document.querySelectorAll('.wp-block-cover-image');

    if( $('.primary-sidebar').length ) {
      const sidebar = $('.primary-sidebar');
      let sidebarTop = sidebar.position().top;
      let sidebarBottom = sidebarTop + sidebar.outerHeight(true);
    }

    function getPosition(element) {
      var yPosition = 0;

      while(element) {
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
      }

      return yPosition;
    }

    function fadeSidebarOnScroll() {
      siteTop = $(window).scrollTop();

      alignWideBlocks.forEach((element) => {
        const alignWide = $(element);
        const alignWideTop = alignWide.position().top;
        const alignWideBottom = alignWide.position().top + alignWide.outerHeight(true);
        let dalignWideTop = alignWideTop - siteTop;
        let dalignWideBottom = alignWideBottom - siteTop;

        if( sidebarBottom > dalignWideTop ) {
          sidebar.addClass('fade-out');
        } else if( sidebarBottom < dalignWideTop ) {
          sidebar.removeClass('fade-out');
        }
      });
    }

    // $(window).on('scroll', function(){
    //   (!window.requestAnimationFrame)
    //     ? setTimeout(fadeSidebarOnScroll, 250)
    //     : requestAnimationFrame(fadeSidebarOnScroll);
    // });



    // Display read time on articles if activated.
    if( true == malik_options.read_time ) {
      $.fn.readingtime = function(options) {

        var settings = $.extend({
          wpm:    250,
          round:  'round'
        }, options);

        var words = $.trim(this.first().text()).split(/\s+/).length;
        return Math[settings.round](words/settings.wpm);
      };

      // For each blog post
      $("article.post").each(function(){

        // Calculate Reading Time
        var ert = $(this).readingtime();

        // Append it to post header if not zero
        if( ert > 0 ) {
          $(this).find('.entry-meta').append('<div class="read-time">' + ert + ' min reading time</div>');
        }
      });
    }

    // Display article progress bar if activated
    if( true == malik_options.progression_bar ) {
      $("body.single").prognroll({
        color: malik_options.link_color
      });
    }

    // Allow nightmode if activated.
    if( true == malik_options.night_mode ) {
      $('#night-mode').on( 'click', function() {
        $(document.body).toggleClass('night-mode');
      });
    }

  }(jQuery));

}); /* end of as page load scripts */


/**
 * Sticky Menu Header
 *
 * Handles whether the header and header menu are sticky or not
 */
jQuery(document).ready(function($) {

  (function( $ ) {

    "use strict";

    /* Get viewport width */
    var responsive_viewport = $(window).width();

    // If header is on the side and screen is wide enough, ignore header stickiness.
    // if( ( 'side' === malik_options.header_location && ( responsive_viewport < 768 ) ) || 'top' === malik_options.header_location ) {

      const siteHeader = $('.site-header');
      const siteHeaderTop = $('.site-header-top');
      const siteNavigation = $('.site-navigation');
      const siteContent = $('.site-content');
      let headerHeight = siteHeader.height();

      // Set scrolling variables
      let scrolling = false;
      let previousTop = 0;
      let currentTop = 0;
      let scrollDelta = 1;
      let scrollOffset = 50;

      if( 'top' === sideOrTop() ) {
        // Push the site content below the fixed header.
        siteContent.css( 'margin-top', headerHeight);

        calculateHeaderTop();
      }

      $(window).on('resize', function(){
        headerHeight = siteHeader.height();
      });

      $(window).on('scroll', function(){
        if( !scrolling ) {
          scrolling = true;
          (!window.requestAnimationFrame)
            ? setTimeout(autoHideHeader, 250)
            : requestAnimationFrame(autoHideHeader);
        }
      });

      function calculateHeaderTop() {
        // Calculate the current distance to the top of the document.
        currentTop = $(window).scrollTop();

        // If we're at the top of the document, add a class to the header.
        if( 0 === currentTop ) {
          siteHeader.addClass('top');
        } else {
          siteHeader.removeClass('top');
        }
      }

      function sideOrTop() {
        // If header is on the side and screen is wide enough, ignore header stickiness.
        if( ( 'side' === malik_options.header_location && ( responsive_viewport < 768 ) ) || 'top' === malik_options.header_location ) {
          return 'top';
        } else {
          return 'side';
        }
      }

      function autoHideHeader() {
        calculateHeaderTop();

        if( 'top' === sideOrTop() ) {
          if( true == malik_options.hide_header && true == malik_options.hide_header_menu ) {
            hideHeaderAndMenu(currentTop);
          } else if( true == malik_options.hide_header ) {
            hideHeader(currentTop);
          } else if( true == malik_options.hide_header_menu ) {
            hideMenu(currentTop);
          }
        } else if( 'side' === sideOrTop() ) {
          if( true == malik_options.hide_header ) {
            sideHide(currentTop);
          }
        }

          previousTop = currentTop;
          scrolling = false;
      }

      function hideHeaderAndMenu(currentTop) {
        // Header menu and header hides on scroll
        if (previousTop - currentTop > scrollDelta) {
          // Scrolling up.
          siteHeader.removeClass('is-hidden');
        } else if( currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
          // Scrolling down.
          siteHeader.addClass('is-hidden');
        }
      }

      function hideHeader(currentTop) {
        // Header menu is sticky on scroll
        var secondaryNavOffsetTop = siteNavigation.height() - siteHeader.height();

        if (previousTop >= currentTop ) {
          // Scrolling up.
          if( currentTop < secondaryNavOffsetTop ) {
            siteHeader.removeClass('is-hidden');
            siteNavigation.removeClass('fixed');
          } else if( previousTop - currentTop > scrollDelta ) {
            siteHeader.removeClass('is-hidden');
            siteNavigation.addClass('fixed');
          }

        } else {
          // Scrolling down.
          if( currentTop > secondaryNavOffsetTop + scrollOffset ) {
            // Hide navigation.
            siteHeader.addClass('is-hidden');
            siteNavigation.addClass('fixed');
          } else if( currentTop > secondaryNavOffsetTop ) {
            // Once the secondary nav is fixed, do not hide primary nav if you haven't scrolled more than scrollOffset.
            siteHeader.removeClass('is-hidden');
            siteNavigation.addClass('fixed');
          }
        }
      }

      function hideMenu(currentTop) {
        // Header menu is hidden on scroll.
        var secondaryNavOffsetTop = siteNavigation.height() - siteHeader.height();

        if (previousTop >= currentTop ) {
          // Scrolling up.
          if( currentTop < secondaryNavOffsetTop ) {
            // Secondary nav is not fixed.
            siteNavigation.removeClass('is-hidden');
          } else if( previousTop - currentTop > scrollDelta ) {
            // Secondary nav is fixed.
            siteNavigation.removeClass('is-hidden');
          }

        } else {
          // Scrolling down.
          if( currentTop > secondaryNavOffsetTop + scrollOffset ) {
            // Hide header navigation.
            siteNavigation.addClass('is-hidden');
          } else if( currentTop > secondaryNavOffsetTop ) {
            siteNavigation.removeClass('is-hidden');
          }
        }
      }

      function sideHide(currentTop) {
        // Header menu and header hides on scroll
        if (previousTop - currentTop > scrollDelta) {
          // Scrolling up.
          siteHeader.removeClass('fade');
        } else if( currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
          // Scrolling down.
          siteHeader.addClass('fade');
        }
      }

    // } // End If Header Top

  }(jQuery));

}); /* end of as page load scripts */


/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
!function(){var e,a,t,s,n,i;if((e=document.getElementById("main-navigation"))&&void 0!==(a=e.getElementsByTagName("button")[0]))if(void 0!==(t=e.getElementsByTagName("ul")[0])){for(t.setAttribute("aria-expanded","false"),-1===t.className.indexOf("nav-menu")&&(t.className+=" nav-menu"),a.onclick=function(){-1!==e.className.indexOf("toggled")?(e.className=e.className.replace(" toggled",""),a.setAttribute("aria-expanded","false"),t.setAttribute("aria-expanded","false")):(e.className+=" toggled",a.setAttribute("aria-expanded","true"),t.setAttribute("aria-expanded","true"))},n=0,i=(s=t.getElementsByTagName("a")).length;n<i;n++)s[n].addEventListener("focus",l,!0),s[n].addEventListener("blur",l,!0);!function(a){var t,s,n=e.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(t=function(e){var a,t=this.parentNode;if(t.classList.contains("focus"))t.classList.remove("focus");else{for(e.preventDefault(),a=0;a<t.parentNode.children.length;++a)t!==t.parentNode.children[a]&&t.parentNode.children[a].classList.remove("focus");t.classList.add("focus")}},s=0;s<n.length;++s)n[s].addEventListener("touchstart",t,!1)}()}else a.style.display="none";function l(){for(var e=this;-1===e.className.indexOf("nav-menu");)"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}}();


/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);


/* PrognRoll | https://mburakerman.github.io/prognroll/ | @mburakerman | License: MIT */
!function(o){o.fn.prognroll=function(t){var e=o.extend({height:5,color:"#50bcb6",custom:!1},t);return this.each(function(){if(o(this).data('prognroll')){return!1}o(this).data('prognroll',!0);var t=o("<span>",{class:"bar"});o("body").prepend(t);t.css({position:"fixed",top:0,left:0,width:0,height:e.height,backgroundColor:e.color,zIndex:9999999});e.custom===!1?o(window).scroll(function(t){t.preventDefault();var e=o(window).scrollTop(),r=o(window).outerHeight(),l=o(document).height(),n=e/(l-r)*100;o(".bar").css("width",n+"%")}):o(this).scroll(function(t){t.preventDefault();var e=o(this).scrollTop(),r=o(this).outerHeight(),l=o(this).prop("scrollHeight"),n=e/(l-r)*100;o(".bar").css("width",n+"%")});o(window).on('hashchange',function(t){t.preventDefault();console.log(o(window).scrollTop())});o(window).trigger('hashchange');var r=o(window).scrollTop(),l=o(window).outerHeight(),n=o("body").outerHeight(),c=r/(n-l)*100;o(".bar").css("width",c+"%")})}}(jQuery)
