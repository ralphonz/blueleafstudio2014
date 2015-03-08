// tipsy, facebook style tooltips for jquery
// version 1.0.0a
// (c) 2008-2010 jason frame [jason@onehackoranother.com]
// released under the MIT license

(function($) {
    
    function maybeCall(thing, ctx) {
        return (typeof thing == 'function') ? (thing.call(ctx)) : thing;
    };
    
    function isElementInDOM(ele) {
      while (ele = ele.parentNode) {
        if (ele == document) return true;
      }
      return false;
    };
    
    function Tipsy(element, options) {
        this.$element = $(element);
        this.options = options;
        this.enabled = true;
        this.fixTitle();
    };
    
    Tipsy.prototype = {
        show: function() {
            var title = this.getTitle();
            if (title && this.enabled) {
                var $tip = this.tip();
                
                $tip.find('.tipsy-inner')[this.options.html ? 'html' : 'text'](title);
                $tip[0].className = 'tipsy'; // reset classname in case of dynamic gravity
                $tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).prependTo(document.body);
                
                var pos = $.extend({}, this.$element.offset(), {
                    width: this.$element[0].offsetWidth,
                    height: this.$element[0].offsetHeight
                });
                
                var actualWidth = $tip[0].offsetWidth,
                    actualHeight = $tip[0].offsetHeight,
                    gravity = maybeCall(this.options.gravity, this.$element[0]);
                
                var tp;
                switch (gravity.charAt(0)) {
                    case 'n':
                        tp = {top: pos.top + pos.height + this.options.offset, left: pos.left + pos.width / 2 - actualWidth / 2};
                        break;
                    case 's':
                        tp = {top: pos.top - actualHeight - this.options.offset, left: pos.left + pos.width / 2 - actualWidth / 2};
                        break;
                    case 'e':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth - this.options.offset};
                        break;
                    case 'w':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width + this.options.offset};
                        break;
                }
                
                if (gravity.length == 2) {
                    if (gravity.charAt(1) == 'w') {
                        tp.left = pos.left + pos.width / 2 - 15;
                    } else {
                        tp.left = pos.left + pos.width / 2 - actualWidth + 15;
                    }
                }
                
                $tip.css(tp).addClass('tipsy-' + gravity);
                $tip.find('.tipsy-arrow')[0].className = 'tipsy-arrow tipsy-arrow-' + gravity.charAt(0);
                if (this.options.className) {
                    $tip.addClass(maybeCall(this.options.className, this.$element[0]));
                }
                
                if (this.options.fade) {
                    $tip.stop().css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: this.options.opacity});
                } else {
                    $tip.css({visibility: 'visible', opacity: this.options.opacity});
                }
            }
        },
        
        hide: function() {
            if (this.options.fade) {
                this.tip().stop().fadeOut(function() { $(this).remove(); });
            } else {
                this.tip().remove();
            }
        },
        
        fixTitle: function() {
            var $e = this.$element;
            if ($e.attr('title') || typeof($e.attr('original-title')) != 'string') {
                $e.attr('original-title', $e.attr('title') || '').removeAttr('title');
            }
        },
        
        getTitle: function() {
            var title, $e = this.$element, o = this.options;
            this.fixTitle();
            var title, o = this.options;
            if (typeof o.title == 'string') {
                title = $e.attr(o.title == 'title' ? 'original-title' : o.title);
            } else if (typeof o.title == 'function') {
                title = o.title.call($e[0]);
            }
            title = ('' + title).replace(/(^\s*|\s*$)/, "");
            return title || o.fallback;
        },
        
        tip: function() {
            if (!this.$tip) {
                this.$tip = $('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"></div>');
                this.$tip.data('tipsy-pointee', this.$element[0]);
            }
            return this.$tip;
        },
        
        validate: function() {
            if (!this.$element[0].parentNode) {
                this.hide();
                this.$element = null;
                this.options = null;
            }
        },
        
        enable: function() { this.enabled = true; },
        disable: function() { this.enabled = false; },
        toggleEnabled: function() { this.enabled = !this.enabled; }
    };
    
    $.fn.tipsy = function(options) {
        
        if (options === true) {
            return this.data('tipsy');
        } else if (typeof options == 'string') {
            var tipsy = this.data('tipsy');
            if (tipsy) tipsy[options]();
            return this;
        }
        
        options = $.extend({}, $.fn.tipsy.defaults, options);
        
        function get(ele) {
            var tipsy = $.data(ele, 'tipsy');
            if (!tipsy) {
                tipsy = new Tipsy(ele, $.fn.tipsy.elementOptions(ele, options));
                $.data(ele, 'tipsy', tipsy);
            }
            return tipsy;
        }
        
        function enter() {
            var tipsy = get(this);
            tipsy.hoverState = 'in';
            if (options.delayIn == 0) {
                tipsy.show();
            } else {
                tipsy.fixTitle();
                setTimeout(function() { if (tipsy.hoverState == 'in') tipsy.show(); }, options.delayIn);
            }
        };
        
        function leave() {
            var tipsy = get(this);
            tipsy.hoverState = 'out';
            if (options.delayOut == 0) {
                tipsy.hide();
            } else {
                setTimeout(function() { if (tipsy.hoverState == 'out') tipsy.hide(); }, options.delayOut);
            }
        };
        
        if (!options.live) this.each(function() { get(this); });
        
        if (options.trigger != 'manual') {
            var binder   = options.live ? 'live' : 'bind',
                eventIn  = options.trigger == 'hover' ? 'mouseenter' : 'focus',
                eventOut = options.trigger == 'hover' ? 'mouseleave' : 'blur';
            this[binder](eventIn, enter)[binder](eventOut, leave);
        }
        
        return this;
        
    };
    
    $.fn.tipsy.defaults = {
        className: null,
        delayIn: 0,
        delayOut: 0,
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        live: false,
        offset: 0,
        opacity: 0.8,
        title: 'title',
        trigger: 'hover'
    };
    
    $.fn.tipsy.revalidate = function() {
      $('.tipsy').each(function() {
        var pointee = $.data(this, 'tipsy-pointee');
        if (!pointee || !isElementInDOM(pointee)) {
          $(this).remove();
        }
      });
    };
    
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
    
    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };
    
    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };
    
    /**
     * yields a closure of the supplied parameters, producing a function that takes
     * no arguments and is suitable for use as an autogravity function like so:
     *
     * @param margin (int) - distance from the viewable region edge that an
     *        element should be before setting its tooltip's gravity to be away
     *        from that edge.
     * @param prefer (string, e.g. 'n', 'sw', 'w') - the direction to prefer
     *        if there are no viewable region edges effecting the tooltip's
     *        gravity. It will try to vary from this minimally, for example,
     *        if 'sw' is preferred and an element is near the right viewable 
     *        region edge, but not the top edge, it will set the gravity for
     *        that element's tooltip to be 'se', preserving the southern
     *        component.
     */
     $.fn.tipsy.autoBounds = function(margin, prefer) {
		return function() {
			var dir = {ns: prefer[0], ew: (prefer.length > 1 ? prefer[1] : false)},
			    boundTop = $(document).scrollTop() + margin,
			    boundLeft = $(document).scrollLeft() + margin,
			    $this = $(this);

			if ($this.offset().top < boundTop) dir.ns = 'n';
			if ($this.offset().left < boundLeft) dir.ew = 'w';
			if ($(window).width() + $(document).scrollLeft() - $this.offset().left < margin) dir.ew = 'e';
			if ($(window).height() + $(document).scrollTop() - $this.offset().top < margin) dir.ns = 's';

			return dir.ns + (dir.ew ? dir.ew : '');
		}
	};
    
})(jQuery);

/*
Bones Scripts File
Author: Eddie Machado

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/

// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
	window.getComputedStyle = function(el) {
		this.el = el;
		this.getPropertyValue = function(prop) {
			var re = /(\-([a-z]){1})/g;
			if (prop ==='float') {prop = 'styleFloat';}
			if (re.test(prop)) {
				prop = prop.replace(re, function () {
					return arguments[2].toUpperCase();
				});
			}
			return el.currentStyle[prop] ? el.currentStyle[prop] : null;
		};
		return this;
	};
}
/*jshint devel:true */

// as the page loads, call these scripts
jQuery(document).ready(function($) {
	
	/*
	Responsive jQuery is a tricky thing.
	There's a bunch of different ways to handle
	it, so be sure to research and find the one
	that works for you best.
	*/
	
	/* getting viewport width */
	var responsive_viewport = $(window).width();
	
	$( window ).resize(function() {
		responsive_viewport = $(window).width();
	});
	
	/* variables */
	var allPanels = $('#slider-page .entry-content');
	var openPanel = $('#slider-page .open-panel');
	var whmcsPage = $('.page-template-page-WHMCS-php');
	
	if (whmcsPage.length > 0 && allPanels.length < 1) {
		$('#content').css({height: 'auto'});
		$('#inner-content').css({height: 'auto'});
		$('#main').css({height: 'auto'});
	}
	
	//iphone only 
//	$(document).on('touchmove', function (ev) {
//        if (!$(ev.target).parents().hasClass('nav')) {
//            ev.preventDefault();
//        }
//    });

//	$('nav').on('touchstart', function(event){});
	
	
	
	/* if is below 481px */
	if (responsive_viewport < 768) {
		
		//content section-box list (web hosting features)
		$('.section-box > ul > li').click(function() {
			$('ul', this).slideToggle();
		});
		
		//mobile nav menu height as vh (viewport units) have a bug on ios 6+
		var viewportHeight = $(window).height() + 70;
		var mobileNav = $('.header nav');
		var mobileSidebar = $('#sidebar1');
		var loginWindow = $('form#login');
		
		mobileNav.css({height: viewportHeight});
		mobileSidebar.css({height: viewportHeight});
		loginWindow.css({height: viewportHeight});
		
		$(window).resize(function() {
			viewportHeight = $(window).height() + 70;
			mobileNav.css({height: viewportHeight});
			mobileSidebar.css({height: viewportHeight});
			loginWindow.css({height: viewportHeight});
		});
		
		//mobile nav menu toggle
		$('#nav-show').click( function () {
			var $righty = $(this).next();
			$righty.animate({
				right: "=0px"
			});
		});
		$('#nav-hide').click( function () {
			var $righty = $(this).parent();
			$righty.animate({
				right: "-=999px"
			});
		});
		
		(function($) {
		    $.fn.clickToggle = function(func1, func2) {
		        var funcs = [func1, func2];
		        this.data('toggleclicked', 0);
		        this.click(function() {
		            var data = $(this).data();
		            var tc = data.toggleclicked;
		            $.proxy(funcs[tc], this)();
		            data.toggleclicked = (tc + 1) % 2;
		        });
		        return this;
		    };
		}(jQuery));
		
		//Mobile sub-menu
		var $submenu = $('header .nav .menu-item-has-children .child-wrap');
			
		$submenu.append('<i class="sub-menu-show fa fa-plus sub-menu-icon"></i>');
		
		$('.sub-menu-show').clickToggle(function () {
			$(this).siblings( ".sub-menu" ).show(500);
			$(this).closest('li').addClass('active-sub-menu');
			$(this).removeClass('fa-plus');
			$(this).addClass('fa-minus');
		}, function() {
			$(this).siblings( ".sub-menu" ).hide(500);
			$(this).closest('li').removeClass('active-sub-menu');
			$(this).removeClass('fa-minus');
			$(this).addClass('fa-plus');
		});
		
	} /* end smallest screen */
	
	/* if is larger than 481px */
	if (responsive_viewport > 481) {
	
	} /* end larger than 481px */
	
	/* if is above or equal to 768px */
	if (responsive_viewport >= 768) {
		
		/* load gravatars */
		$('.comment img[data-gravatar]').each(function(){
			$(this).attr('src',$(this).attr('data-gravatar'));
		});
		
		//content section-box list (web hosting features list)
		var allLi = $('.section-box > ul > li > ul');
		$('.section-box > ul > li').hover(function() {
			$('.active-feature').removeClass('active-feature');
			allLi.hide();
			$('ul', this).show();
			$(this).addClass('active-feature');
			var sectionHeight = $('ul', this).outerHeight();
			var listHeight = $('.section-box > ul').outerHeight();
			if (sectionHeight > listHeight) {
				$(this).closest('.section-box').height(sectionHeight + 150);
			} else {
				$(this).closest('.section-box').height(listHeight + 150);
			}
			
		});
		
		//tipsy
		$('.next-project a').tipsy({gravity: 'e'});
		$('.prev-project a').tipsy({gravity: 'w'});
		
		$('.show-tooltip').tipsy();
		$('.show-tooltip-e').tipsy({gravity: 'e'});
		$('.show-tooltip-w').tipsy({gravity: 'w'});
		$('.show-tooltip-s').tipsy({gravity: 's'});
		$('.show-tooltip-focus').tipsy({trigger: 'focus'});
		
	}
	
	if (responsive_viewport < 1004) {
	
		//portfolio slider
		allPanels.hide();
		
		$(".entry-content", openPanel ).slideDown(500);
		$(".article-header", openPanel ).addClass('underside');
		
		$('#slider-page .article-header').click(function() {
			var thisPanel = $(this).siblings('section');
			if (thisPanel.is(":visible")) {
				thisPanel.slideUp(500);
				$(this).removeClass('underside');
			} else {
				allPanels.slideUp(500);
				allPanels.siblings('.article-header').removeClass('underside');
				thisPanel.slideDown(500);
				$(this).addClass('underside');
			}
		});
		
	} /* end smallest screen */
	
	if (responsive_viewport >= 1004) {
	
		//portfolio slider
		var articleHeaders = $('#slider-page .article-header');
		var headersWidth = articleHeaders.length * 70 + 5;
		var panelWidth = $('#slider-page').width() - headersWidth;
		
		if (openPanel.length < 1) {
			openPanel = $( "#slider-page article:first-of-type");
		}
		
		allPanels.css('overflowY', 'hidden');
		$(".entry-content", openPanel ).css({width: panelWidth, overflowY: 'auto'});
		$(".article-header", openPanel ).addClass('underside');
		articleHeaders.click(function() {
			var thisPanel = $(this).siblings('section');
			if (thisPanel.width() === 0) {
				allPanels.animate({width: '0'});
				thisPanel.animate({width: panelWidth});
				allPanels.css('overflowY', 'hidden');
				
				thisPanel.css('overflowY', 'auto');
				$('.underside').removeClass('underside');
				$(this).addClass('underside');
			}
		});
		
	} /* end smallest screen */
	
	/* off the bat large screen actions */
	if (responsive_viewport > 1030) {
	
	}
	
	// add all your scripts here
	
	$(window).load(function(){
		$("#loading-overlay").fadeOut();
	});
	
	//frontpage stuff
//	if (typeof $.fn.fullpage ==='function') {
//		$.fn.fullpage({
//			anchors: ['Slide1', 'Slide2', 'Slide3', 'Slide4', 'Slide5'],
//			menu: '#fullPage-menu',
//			css3: true,
//			fixedElements: 'header.header, form#login, #sidebar1, #fullPage-menu, #cookie-notice, #login-button, #loading-overlay',
//			continuousVertical: true,
//			resize : false,
//		});
//	}
	
	var totalWidth = $('body').width();
	var homeLogo = $('.page-template-page-home-php #logo');
	homeLogo.attr('title', 'Show/Hide the main menu bar');
	homeLogo.tipsy({gravity: 'nw'});
	homeLogo.click(function (e) {
		e.preventDefault();
		var header = $('.header');
		if (header.width() < 1) {
			$('.header nav').animate({opacity: 1});
			header.animate({
				width: totalWidth
			}, 500);
		} else {
			$('.header nav').animate({opacity: 0});
			header.animate({
				width: 0
			}, 500);
		}
		
	});
	
	//sidebar toggle
	var $lefty = $('#sidebar1');
	$("#sidebar-show").click( function(event){
		event.preventDefault();
		if ($(this).hasClass("isShowing") ) {
			$lefty.animate({
				left: "-=9999px"
			});
			$(this).removeClass("isShowing");
		} else {
			$lefty.animate({
				left: "=0px"
			});
			$(this).addClass("isShowing");
		}
		return false;
	});
	
	$('#sidebar-hide').click( function () {
		var $lefty = $('#sidebar1');
		$lefty.animate({
			left: "-=9999px"
		});
	});
	
	//portfolio page nav
	var prevButton = $('.prev-project');
	var nextButton = $('.next-project');
	if (prevButton.children().length === 0) {
		prevButton.css({opacity: '0.5'});
	}
	if (nextButton.children().length === 0) {
		nextButton.css({opacity: '0.5'});
	}
	
	
	//scroll back to top
	$("a[href='#top']").click(function() {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
	
	//Page Sections
	var headerHeight = $('.header').height();

	$(".section-anchor").click(function() {
		$('html, body').animate({
			scrollTop: $(this).offset().top - headerHeight - 16
		}, 1000);
		$(this).css({ WebkitTransform: 'rotate(180deg)', '-moz-transform': 'rotate(180deg)', transform: 'rotate(180deg)'});
	});
	
	$(window).scroll(function () {
		var windowHeight = $(window).height() / 2;
		
		$('.section-anchor').each(function() {
			var scrollTop     = $(window).scrollTop(),
				elementOffset = $(this).offset().top,
				distance      = (elementOffset - scrollTop),
				self = $(this);
				
			if (distance < windowHeight) {
				$(this).unbind( "click" );
				$(this).click(function (e) {
					e.preventDefault();
					$('html, body').animate({
						scrollTop: $(this).parent('section').prev('section').offset().top - (headerHeight + 64)
					}, 1000);
				});
				self.css({ WebkitTransform: 'rotate(180deg)', '-moz-transform': 'rotate(180deg)', transform: 'rotate(180deg)'});
			} else {
				$(this).unbind( "click" );
				$(this).click(function(e) {
					e.preventDefault();
					$('html, body').animate({
						scrollTop: $(this).offset().top - headerHeight - 16
					}, 1000);
				});
				self.css({ WebkitTransform: 'rotate(0deg)', '-moz-transform': 'rotate(0deg)', transform: 'rotate(0deg)'});
			}
		});
	});
	
	//hide whmcs
	$("p:contains('Powered by')").css({display: 'none'});
	
	//Quote form stuff
	$('#customfield10 option:first').attr('disabled', 'disabled');
	$('#customfield18 option:first').attr('disabled', 'disabled');
	
	$('.project-type-questions').css({display : 'none'});
	
	$("#customfield10").change(function () {
		var str = "";
		str = $(this).val();
		if (str === ' New website or full re-design') {
			$("#full-website").slideDown();
		} else {
			$("#full-website").slideUp();
		}
	});
	
	$(".please-specify").css({display : 'none'});
	
	$("#customfield22").click(function () {
		$("#printed-material-specify").slideToggle();
	});
	
	$("#customfield21").click(function () {
		$("#domain-specify").slideToggle();
	});
	
	//Cart stuff
	$('input[name="domains[]"]').change(function () {
		$('.cart-next-step').removeAttr('disabled');
	});
	
	//Domain checker stuff
	var domainsAlert = $('.domains-page .alert');
	var domainsLookup = $('.domains-page .domain-lookup');
	
	if (domainsAlert.length > 0 || domainsLookup.length > 0) {
		$(document).scrollTop( $(".section-box").offset().top );
	}
	
}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
	var doc = w.document;
	if( !doc.querySelector ){ return; }
	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;
	if( !meta ){ return; }
	function restoreZoom(){
		meta.setAttribute( "content", enabledZoom );
		enabled = true; }
	function disableZoom(){
		meta.setAttribute( "content", disabledZoom );
		enabled = false; }
	function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );