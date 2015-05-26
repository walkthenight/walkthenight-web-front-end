/* global jQuery, cbScripts, cookie */
(function($) { "use strict";

    var cbBGOverlay = $('#cb-overlay'),
    cbBody = $('body'),
    cbWindow = $(window),
    cbDoc = $(document),
    cbWindowHeight = cbWindow.height() + 1,
    cbWindowWidth = cbWindow.width(),
    cbMain = $('#main'),
    cbPostEntryContent = cbMain.find('.cb-entry-content'),
    cbImagesAlignNone = cbPostEntryContent.find('.alignnone'),
    cbMainNavCont = $('.cb-main-nav'),
    cbNavMenuTopLevel = cbMainNavCont.children(),
    cbSlider1Post = $('.cb-slider-1'),
    cbSlider2Posts = $('.cb-slider-2'),
    cbSlider3Posts = $('.cb-slider-3'),
    cbHTMLBody = $('html, body'),
    cbToTop = $('#cb-to-top'),
    cbModFs = $('.cb-module-block-fs'),
    cbContainer = $('#cb-container'),
    cbContent = $('#cb-content'),
    cbVerticalNavDown = $('.cb-vertical-down'),
    cbPostFeaturedImage = $('#cb-featured-image'),
    cbFisFS = $('.cb-fis-fs'),
    cbGalleryPost = $('#cb-gallery-post'),
    cbNavBar = $('#cb-nav-bar'),
    cbMSearchTrig = $('#cb-s-trigger'),
    cbMSearch = $('#cb-menu-search'),
    cbMSearchI = cbMSearch.find('input'),
    cbMSearchAllResults = $('#cb-s-all-results'),
    cbTrendMenuItem = $('#cb-trend-menu-item'),
    cbWindowScrollTop,
    cbWindowScrollTopCache = 0,
    cbTimer = 0,
    cbStickyBotCache = 0,
    cbStickyTopCache = 0,
    cbResults = cbMSearch.find("#cb-s-results"),
    cbLWA = $('#cb-lwa'),
    cbLWATrigger = $('#cb-lwa-trigger'),
    cbcloser = $('.cb-close-m').add(cbBGOverlay),
    cbLWALogRegTrigger = cbLWA.find('.cb-title-trigger'),
    cbLWAForms = cbLWA.find('.lwa-form'),
    cbLWAinputuser = cbLWAForms.find('.cb-form-input-username'),
    cbStickySB = cbContainer.find('.cb-sticky-sidebar'),
    cbStickySBEL = cbStickySB.find('.cb-sidebar'),
    cbStickySBELPT = cbStickySBEL.css('padding-top'),
    cbCodes = [9, 13, 16, 17, 18, 20, 32, 45, 116],
    cbFooterEl = $('#cb-footer'),
    cbMobOp = $('#cb-mob-open'),
    cbMobCl = $('#cb-mob-close'),
    cbMedia = $('#cb-media-play'),
    cbReady = true,
    cbInfiniteScroll = $('#cb-blog-infinite-scroll'),
    cbSectionLP = $('#cb-section-lp'),
    cbTMS = $('#cb-top-menu').find('.cb-top-menu-wrap'),
    cbRatingBars = $('#cb-review-container').find('.cb-overlay span'),
    cbParallaxImg = $('#cb-par-wrap').find('.cb-image'),
    cbWindowHeightTwo,
    cbLoad = false,
    cbAdminBar = false,
    cbCheckerI = false,
    cbFlag = false,
    cbBodyRTL = false,
    cbStickyTopVal,
    cbMenuOffset,
    cbStickyHeightCache,
    cbOverlaySpan,
    cbNonce,
    cbMenuHeight,
    cbIFrames = cbPostEntryContent.find('iframe'),
    cbMobileTablet = !!( ( navigator.userAgent.match(/Android/i) === true ) || ( navigator.userAgent.match(/BlackBerry/i) === true ) || ( navigator.userAgent.match(/iPhone|iPod|iPad|iWatch/i) ) || ( navigator.userAgent.match(/Motorola|DROIDX/i) ) || ( navigator.userAgent.match(/Linux/i) ) || ( navigator.userAgent.match(/IEMobile/i) === true ) );

    if ( cbBody.hasClass('rtl') ) { cbBodyRTL = true; }
    if ( cbBody.hasClass('admin-bar') ) { cbAdminBar = true; }
    if ( cbNavBar.length ) {
        if  ( cbWindowWidth > 767 ) {
            cbMenuHeight = cbNavBar.outerHeight();
        }
    }
    if ( cbSectionLP.length ) {
        cbStickySB = cbSectionLP.find('.cb-sticky-sidebar');
        cbStickySBEL = cbStickySB.find('.cb-sidebar');
        cbStickySBELPT = cbStickySBEL.css('padding-top');
    } 

    if ( cbFisFS.length ) {
        var cbFisFSOffTop = cbPostFeaturedImage.offset().top;
        cbWindowHeightTwo =  cbWindowHeight - cbFisFSOffTop;
    }

    cbNavBar.css( 'height', cbMenuHeight );
    cbFisFS.css( 'height', cbWindowHeightTwo );

    if ( cbGalleryPost.length ) {
        cbGalleryPost.find('img').css( 'height', cbWindowHeight + 1  );
    }

    cbIFrames.each( function() {
        var CbThisSrc = $(this).attr('src');
        
        if( CbThisSrc && ( ( CbThisSrc.indexOf("yout") > -1 ) || ( CbThisSrc.indexOf("vimeo") > -1 ) || ( CbThisSrc.indexOf("daily") > -1 ) ) ) {
            $(this).wrap('<div class="cb-video-frame"></div>');
        } 
    });

    cbMobOp.click( function(e) {

        e.preventDefault();
        cbBody.addClass('cb-mob-op');

    });

    cbTrendMenuItem.click( function(e) {

        e.preventDefault();

    });

    cbMobCl.click( function(e) {

        e.preventDefault();
        cbBody.removeClass('cb-mob-op');

    });

    function cbOnScroll() {

         if ( cbAdminBar === true ) {
            if ( cbWindowWidth > 781 ) {
                cbWindowScrollTop = cbWindow.scrollTop() + 32;
            } else {
                cbWindowScrollTop = cbWindow.scrollTop() + 46;
            }
        } else {
            cbWindowScrollTop = cbWindow.scrollTop();
        }

        cbChecker();

    }

    function cbChecker() {
        
        if ( ! cbCheckerI ) {
            requestAnimationFrame(cbScrolls);
            cbCheckerI = true;
        }
    }

    function cbFixdSidebarLoad() {

        if ( cbLoad === false ) {
            cbScrolls();
            cbScrolls();
            cbLoad = true;
        }
    }

    function cbScrolls() {

        if ( cbBody.hasClass( 'cb-sticky-mm' ) ) {

            if ( ! cbBody.hasClass('cb-sticky-menu-up') ) {
                if ( cbWindowScrollTop >= cbMenuOffset ) {

                    cbBody.addClass('cb-stuck');

                } else {
                    cbBody.removeClass('cb-stuck');
                }
            } else {

                if ( ( cbWindowScrollTop >= cbMenuOffset ) && ( cbWindowScrollTopCache > cbWindowScrollTop ) ) {

                    cbBody.addClass('cb-stuck');

                } else {
                    cbBody.removeClass('cb-stuck');
                }

                cbWindowScrollTopCache = cbWindowScrollTop;
            }
            
        }

        if ( ( cbWindowWidth > 767 ) && ( cbMobileTablet === false ) ) {
            if ( cbStickySB.length ) {

                var cbStickyLoc = cbStickySB.offset().top,
                    cbStickyHeight = cbStickySBEL.outerHeight(true),
                    cbFooterElTop = cbFooterEl.offset().top,
                    cbStickyBot = cbStickyLoc + cbStickyHeight,
                    cbCurScroll = cbWindowHeight + cbWindowScrollTop;

                       if ( cbFlag === false ) {
                        cbStickyHeightCache = cbStickyHeight;
                        cbFlag = true;
                    }

                    if ( cbStickyHeightCache < cbStickyHeight ) {
                        cbStickyHeightCache = cbStickyHeight;
                        cbStickyBot = cbStickyLoc + cbStickyHeight;
                        cbStickyBotCache = cbStickyBot;
                    }

                if ( cbStickyHeightCache > cbWindowHeight ) {
                    // CBTLRTW

                    cbStickySB.css('height', cbStickyHeightCache);
                    cbBody.removeClass('cb-stuck-sb-t');
                    if ( ! cbBody.hasClass('cb-stuck-sb') ) {
                        
                        if (  ( cbCurScroll > cbStickyBot ) && ( cbWindowScrollTop < cbFooterElTop ) && ( cbWindowScrollTop > cbStickyLoc ) ) {
                            cbBody.addClass('cb-stuck-sb');
                            cbStickyBotCache = cbStickyBot;
                        }
                        
                        if ( cbCurScroll > cbFooterElTop ) {
                            cbBody.addClass('cb-footer-vis');
                        }
                        
                    } else {
                        if ( ( ! cbFooterEl.visible(true) ) && ( cbWindowScrollTop < cbFooterElTop ) ) {
                            cbBody.removeClass('cb-footer-vis');
                            cbStickySBEL.css('top', 'auto' );
                        }  else {
                            cbBody.addClass('cb-footer-vis');
                            cbStickySBEL.css('top', cbFooterElTop - cbStickyHeightCache + 'px' );
                        }
                        
                        if ( cbCurScroll < cbStickyBotCache ) {
                            cbBody.removeClass('cb-stuck-sb');
                        }
                    }

                } else {
                    // CBSRTTW

                    if ( cbAdminBar === true ) {
                        cbStickyTopVal = cbMenuHeight +  32;
                        cbStickyTopCache = cbStickyLoc - parseInt(cbStickySBELPT, 10) - cbMenuHeight + 32;
                    } else {
                        cbStickyTopVal = cbMenuHeight;
                        cbStickyTopCache = cbStickyLoc - parseInt(cbStickySBELPT, 10) - cbMenuHeight;
                    }
                    cbStickySB.css('height', cbStickyHeightCache);

                    if ( ! cbBody.hasClass('cb-stuck-sb') ) {

                        if ( cbBody.hasClass('cb-stuck') && ( ! cbBody.hasClass('cb-fis-big-block') ) )  {
                            cbStickySBEL.css('top', cbStickyTopVal );
                        }
                        
                        if ( cbWindowScrollTop >= cbStickyTopCache ) {
                            cbBody.addClass('cb-stuck-sb cb-stuck-sb-t');
                            if ( cbBody.hasClass('cb-fis-big-block') ) {
                                cbStickySBEL.css('top', cbStickyTopVal );
                            }
                        }

                    } else {

                        if ( cbFooterElTop > ( cbCurScroll - ( cbWindowHeight - cbStickyHeightCache ) ) ) {
                            cbBody.removeClass('cb-footer-vis');
                             
                            if ( cbBody.hasClass('cb-stuck') ) {
                                cbStickySBEL.css('top', cbStickyTopVal );
                            } else {
                                cbStickySBEL.css('top', '0' );
                            }
                            
                        }  else {
                            cbBody.addClass('cb-footer-vis');
                            cbStickySBEL.css('top', cbFooterElTop - (cbStickyHeightCache ) + 'px' );
                        }
                        
                        if ( cbWindowScrollTop < cbStickyTopCache ) {
                            cbBody.removeClass('cb-stuck-sb cb-stuck-sb-t');
                            if ( cbBody.hasClass('cb-stuck') ) {
                                cbStickySBEL.css('top', cbStickyTopVal );
                            } else {
                                cbStickySBEL.css('top', '0' );
                            }
                        }
                    }
                }
            }
        }

        if ( ( cbWindowWidth < 768 ) && ( cbAdminBar === true ) ) {

            if ( ( ( 92 - cbWindowScrollTop ) >= 0 ) ) {
                cbBody.removeClass('cb-tm-stuck');
                if ( cbWindowScrollTop == 32 ) {
                    cbTMS.css('top', 46 );
                } else {
                    cbTMS.css('top', ( 92 - cbWindowScrollTop ) );
                }
                
            } else {
                cbBody.addClass('cb-tm-stuck');
                cbTMS.css('top', 0 );
            }
        }

        if ( ( cbParallaxImg.length !== 0 ) && ( cbMobileTablet === false ) ) {

            if ( cbWindowScrollTop <  cbWindowHeight ) {
                cbBody.removeClass('cb-par-hidden');
                if ( cbAdminBar === true) {
                    cbWindowScrollTop = cbWindowScrollTop - 32;
                }

                var cbyPos = -( ( cbWindowScrollTop / 2    ) ),
                    cbCoords = cbyPos + 'px';

                    $('#cb-par-wrap').css({ '-webkit-transform': 'translate3d(0, ' + cbCoords + ', 0)', 'transform': 'translate3d(0, ' + cbCoords + ', 0)' });
            } else {
                cbBody.addClass('cb-par-hidden');
            }

        }

        if ( cbInfiniteScroll.length ) {

            if ( cbReady === true ) {

                var cbLastChild = $('#main').children().last(),
                    cbLastChildID = cbLastChild.attr('id'),
                    cbLastArticle = cbLastChild.prev();
                if ( cbLastArticle.hasClass('cb-grid-x') ) {
                    cbLastArticle = cbLastArticle.children().last();
                } 
                if ( ( cbLastChildID === 'cb-blog-infinite-scroll' ) && ( cbLastArticle.visible( true ) ) ) {

                    cbReady = false;

                    var cbCurrentPagination = $('#cb-blog-infinite-scroll').find('a').attr('href');
                    cbMain.addClass('cb-pre-load cb-pro-load');

                    $.get( cbCurrentPagination, function( data ) {

                        var cbExistingPosts, cbExistingPostsRaw;

                        cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');
                        $(cbExistingPostsRaw).find('.cb-category-top, .cb-module-header, .cb-grid-block').remove();
                        cbExistingPosts = cbExistingPostsRaw.html();
                        $('#main').children().last().remove();
                        $('#main').append(cbExistingPosts);
                        cbMain.removeClass('cb-pro-load');

                    });

                }

            }
        }

        $.each(cbRatingBars, function(index, element) {

            var cbValue = $(element);
            if ( cbValue.visible(true) ) {
                cbValue.addClass('cb-trigger');

            }
        });

        cbCheckerI = false;
    }

    window.addEventListener( 'scroll', cbOnScroll, false );

    cbImagesAlignNone.each( function() {

        var cbThis = $(this);
       
        if ( cbBody.hasClass( cbScripts.cbFsClass ) ) {

            if ( cbThis.hasClass('wp-caption') ) {
                var cbThisImg = cbThis.find('img');

                if  ( cbThisImg.hasClass( 'size-full' ) ) {

                    if ( cbBodyRTL === true ) {
                        cbThis.css( { 'margin-right': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' }).addClass('cb-fs-embed');
                    } else {
                        cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' }).addClass('cb-fs-embed');
                    }

                    cbThis.add(cbThisImg).css( 'width', cbWindowWidth );
                }

            } else if ( cbThis.hasClass( 'size-full' ) ) {

                if ( cbBodyRTL === true ) {
                    cbThis.css( { 'margin-right': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
                } else {
                    cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
                }

            }
        }

    });    

    cbVerticalNavDown.click( function( e ) {

        e.preventDefault();
        cbHTMLBody.animate({ scrollTop: ( cbMain.offset().top - 60 ) }, 1500);
        
    });

    cbToTop.click( function( e ) {

        e.preventDefault();
        cbHTMLBody.animate( {scrollTop: 0 }, 1500 );

    });

    $('.cb-module-half:odd').each(function(){
        $(this).prev().addBack().wrapAll($('<div/>', {'class': 'cb-double-block clearfix'}));
    });

    cbModFs.each( function() {
        var cbThis = $(this);
        cbThis.css( { 'margin-left': ( ( cbContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
    });

    cbLWATrigger.click( function( e ) {
        e.preventDefault();
        cbBody.addClass('cb-lwa-modal-on');
        if ( cbMobileTablet === false ) {
            cbLWAinputuser.focus();
        }
        
    });

    cbMSearchTrig.click( function( e ) {
        e.preventDefault();
       
        cbBody.addClass('cb-s-modal-on');
        if ( cbMobileTablet === false ) {
            cbMSearchI.focus();
        }
    });

    cbMedia.click( function( e ) {
        e.preventDefault();
        cbBody.addClass('cb-m-modal-on');

    });
    
    cbcloser.click( function() {
        cbBody.removeClass('cb-lwa-modal-on cb-s-modal-on cb-m-modal-on');
    });

    

    cbDoc.keyup(function(e) {

        if (e.keyCode == 27) { 
            cbBody.removeClass('cb-lwa-modal-on');
        }   
    });
    var cbLWAform = cbLWA.find('.lwa-form'),
        cbLWApass = cbLWA.find('.lwa-remember'),
        cbLWAregister = cbLWA.find('.lwa-register-form');

    cbLWALogRegTrigger.click( function( e ) {
        e.preventDefault();
        var cbThis = $(this);

        cbLWALogRegTrigger.removeClass('cb-active');
        cbThis.addClass('cb-active');

        if ( cbThis.hasClass('cb-trigger-reg') ) {
            
            cbLWAform.add(cbLWApass).removeClass('cb-form-active');
            cbLWAregister.addClass('cb-form-active');

        } else if ( cbThis.hasClass('cb-trigger-pass') ) {
            cbLWAregister.add(cbLWAform).removeClass('cb-form-active');
            cbLWApass.addClass('cb-form-active');
        } else {
            cbLWAregister.add(cbLWApass).removeClass('cb-form-active');
            cbLWAform.addClass('cb-form-active');
        }

    });


    $('.tiled-gallery').find('a').attr('rel', 'tiledGallery');
    $('.gallery').find('a').attr('rel', 'tiledGallery');

    $(document).ready(function($) {
        if ( cbNavBar.length ) {
            if  ( cbWindowWidth > 767 ) {
                cbMenuOffset = cbNavBar.offset().top;
            }
        }

        $('.cb-toggler').find('.cb-toggle').click(function(e) {
            e.preventDefault();
            $(this).parent().toggleClass('cb-on');
        });

        $('.cb-tabs').find('> ul').tabs('.cb-panes .cb-tab-content');

        cbMain.find('.hentry').find('a').has('img').each(function () {

            var cbImgTitle = $('img', this).attr( 'title' ),
                cbAttr = $(this).attr('href');

            var cbWooLightbox = $(this).attr('rel');

            if (typeof cbImgTitle !== 'undefined') {
                $(this).attr('title', cbImgTitle);
            }

            if ( ( typeof cbAttr !== 'undefined' )  && ( cbWooLightbox !== 'prettyPhoto[product-gallery]' ) ) {
                var cbHref = cbAttr.split('.');
                var cbHrefExt = $(cbHref)[$(cbHref).length - 1];

                if ((cbHrefExt === 'jpg') || (cbHrefExt === 'jpeg') || (cbHrefExt === 'png') || (cbHrefExt === 'gif') || (cbHrefExt === 'tif')) {
                    $(this).addClass('cb-lightbox');
                }
            }

        });
        
        $('.cb-video-frame').fitVids();
        if ( !!$.prototype.boxer ) {
            $(".cb-lightbox").boxer({ fixed: true }); 
        }

        $('.cb-tip-bot').tipper({
            direction: 'bottom',
            follow: true
        });

        cbSlider1Post.flexslider({
          maxItems: 1,
          minItems: 1,
          startAt: 1,
          animation: "slide",
          slideshow: true,
          controlNav: false,
          nextText: '<i class="fa fa-angle-right"></i>',
          prevText: '<i class="fa fa-angle-left"></i>',
        });

        $('.cb-slider-grid-3').flexslider({
          maxItems: 1,
          minItems: 1,
          startAt: 1,
          animation: "slide",
          slideshow: true,
          itemMargin: 3,
          controlNav: false,
          nextText: '<i class="fa fa-angle-right"></i>',
          prevText: '<i class="fa fa-angle-left"></i>',
        });

        cbSlider2Posts.flexslider({
          maxItems: 2,
          startAt: 0,
          minItems: 1,
          animation: "slide",
          slideshow: true,
          itemWidth: 300,
          itemMargin: 3,
          controlNav: false,
          nextText: '<i class="fa fa-angle-right"></i>',
          prevText: '<i class="fa fa-angle-left"></i>',
        });

        cbSlider3Posts.flexslider({
          maxItems: 3,
          minItems: 1,
          startAt: 0,
          animation: "slide",
          slideshow: true,
          itemWidth: 300,
          itemMargin: 3,
          controlNav: false,
          nextText: '<i class="fa fa-angle-right"></i>',
          prevText: '<i class="fa fa-angle-left"></i>',
        });

        if ( cbMobileTablet === false ) {
           cbNavMenuTopLevel.hoverIntent(function(){
                cbBody.addClass('cb-mm-on');
            }, function() {
                 cbBody.removeClass('cb-mm-on');
            });
        } else {
            cbNavMenuTopLevel.on('click', function(e) {
                var cbThis = $(this);
                cbThis.siblings('.cb-tap').removeClass('cb-tap');
                if ( cbThis.hasClass('cb-tap') ) {
                    return true;
                } else {
                    e.preventDefault();
                    cbBody.addClass('cb-mm-on');
                    cbThis.addClass('cb-tap');
                }
            });
        }

        cbHTMLBody.on( 'mousewheel DOMMouseScroll', function() {
            cbHTMLBody.stop();
        });


        cbDoc.ajaxStop(function() {
          cbReady = true;
          $('.cb-pro-load').removeClass('cb-pro-load');
        });

        cbContent.on('click', '#cb-blog-infinite-load a', function( e ){

            e.preventDefault();
            var cbCurrentPagination = $(this).attr( 'href' ),
              cbCurrentParent = $(this).parent();

            if( $(this).hasClass('cb-pre-load') ) {
                return;
            }
            cbMain.addClass( 'cb-pre-load cb-pro-load' );
            $(this).addClass( 'cb-pre-load' );

            $.get( cbCurrentPagination, function( data ) {

                var cbExistingPosts, cbExistingPostsRaw;

                cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');

                $(cbExistingPostsRaw).find('.cb-category-top, .cb-module-header, .cb-grid-block').remove();

                $(cbExistingPostsRaw).children().addClass( 'cb-slide-visible' );
                cbExistingPosts = cbExistingPostsRaw.html();

                $('#main').append(cbExistingPosts);
                cbMain.removeClass('cb-pro-load');
                cbCurrentParent.addClass( 'cb-hidden' );

            });

        });

        $('.cb-c-l').hoverIntent(function(){

            var cbThis = $(this),
                cbThisText = $(this).text(),
                cbBigMenu = cbThis.closest('div');

            if ( cbBigMenu.hasClass('cb-big-menu') ) {

                var cid = cbThis.attr('data-cb-c'),
                    chref = cbThis.attr('href'),
                    cbBigMenuEl = $(cbBigMenu[0].firstChild),
                    cbBigMenuUL = cbBigMenuEl.find('ul'),
                    cbBigMenuUT = cbBigMenuEl.find('.cb-upper-title'),
                    cbBigMenuSA = cbBigMenuUT.find('.cb-see-all'),
                    cbBigMenuUTH2 = cbBigMenuUT.find('h2');

                if ( cbBigMenuUTH2.text() !== cbThisText ) {

                    $.ajax({
                        type : "GET",
                        data : { action: 'cb_mm_a', cid: cid, acall: 1 },
                        url: cbScripts.cbUrl,
                        beforeSend : function(){
                            cbBigMenuEl.addClass('cb-pro-load');
                        },
                        success : function(data){
                            cbBigMenuUTH2.text(cbThisText);
                            cbBigMenuUL.html($(data));
                            cbBigMenuSA.attr('href', chref);
                        },
                        error : function(jqXHR, textStatus, errorThrown) {
                            console.log("cbmm " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                            }
                    });
                }
            }

        }, function() {});

        $('.cb-trending-op').click(function(e ){
            e.preventDefault();
            var cbThis = $(this),
                cbTBlock = $('#cb-trending-block'),
                cbAllOptions = cbTBlock.find('.cb-trending-op'),
                cbTBlockUL = cbTBlock.find('#cb-trend-data'),
                cbr = cbThis.attr('data-cb-r');

            if ( ! cbThis.hasClass('cb-selected') ) {

                $.ajax({
                    type : "GET",
                    data : { action: 'cb_t_a', cbr: cbr },
                    url: cbScripts.cbUrl,
                    beforeSend : function() {
                        cbTBlock.addClass('cb-pro-load');
                    },
                    success : function(data){
                        cbAllOptions.removeClass('cb-selected');
                        cbThis.addClass('cb-selected');
                        cbTBlockUL.html($(data));
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        console.log("cbr " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                        }
                });
            }

        });

        cbMSearchI.keyup(function( e ) {

            if ( cbTimer ) {
                clearTimeout(cbTimer);
            }

            if ( e.keyCode == 27 ) { 
                cbBody.removeClass('cb-lwa-modal-on');
            } else if ( $.inArray( e.keyCode, cbCodes ) == -1 ) {
                cbTimer = setTimeout( cbSa, 300 ); 
            }
            
        });

        function cbSa() {

            var cbThisValue = cbMSearchI.val();
            if ( cbThisValue.length === 0 ) cbResults.empty();
            if ( cbThisValue.length < 3 ) return;
            $.ajax({
                type : "GET",
                data : { action: 'cb_s_a', cbi: cbThisValue },
                url: cbScripts.cbUrl,
                beforeSend : function(){
                    cbMSearch.find('.cb-s-modal-inner').addClass('cb-pro-load');
                },
                success : function(data){
                    cbMSearch.addClass('cb-padded');
                    cbResults.html( $(data) );
                    cbMSearchAllResults.attr('href', 'http://test');
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    console.log("cbsa " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }

        if ( cbFisFS.length ) {

            var cbFisFSOffTop = cbPostFeaturedImage.offset().top,
            cbWindowHeightTwo =  cbWindowHeight - cbFisFSOffTop;  

            cbFisFS.css( 'height', cbWindowHeightTwo );
        }

    });

    $(window).load(function() { 

        var cbTabber = $('.tabbernav'),
        cbTaggerLength = cbTabber.children().length;
        if ( cbTaggerLength === 4 ) { cbTabber.addClass("cb-tab-4"); }
        if ( cbTaggerLength === 3 ) { cbTabber.addClass("cb-tab-3"); }
        if ( cbTaggerLength === 2 ) { cbTabber.addClass("cb-tab-2"); }
        if ( cbTaggerLength === 1 ) { cbTabber.addClass("cb-tab-1"); }

        if ( cbAdminBar === true ) { 
            cbWindowScrollTop = cbWindow.scrollTop() + 32;
        } else {
            cbWindowScrollTop = cbWindow.scrollTop();
        }

        cbFixdSidebarLoad();
        
         cbGalleryPost.flexslider({
            nextText: '<i id="cb-gallery-next" class="fa fa-angle-right"></i>',
            prevText: '<i id="cb-gallery-prev" class="fa fa-angle-left"></i>',
            animation: "slide",
            startAt: 1,
            controlNav: false,
            itemMargin: 5,
            slideshow: false,
            variableImageWidth: true,
            start: function() {
                cbGalleryPost.removeClass('cb-background-preload').find('.cb-meta').addClass('cb-ani-fade-in-1-5s');
            },
            
        });

        var cbGalleryPostArrows = cbGalleryPost.find('#cb-gallery-next, #cb-gallery-prev').parent();

        cbGalleryPostArrows.hover( function() {

            cbGalleryPost.toggleClass('cb-arrows-hover');

        });

        if ( cbMobileTablet === true ) {

            cbGalleryPostArrows.on('tap', function(){
                
                cbGalleryPost.addClass('cb-arrows-hover');

            });
            var cbGalleryImgs = cbGalleryPost.find('.cb-link-overlay');
            cbGalleryImgs.on('tap', function(){
                
                cbGalleryPost.removeClass('cb-arrows-hover');

            });

            cbGalleryImgs.on('swipe', function(){
                
                cbGalleryPost.addClass('cb-arrows-hover');

            });

        }

    });

    $(window).resize(function() {
        var cbFisFSOffTop, cbWindowHeightTwo;
        cbWindowHeight = cbWindow.height() + 1;
        cbWindowWidth = cbWindow.width();
        if ( ( cbFisFS.length ) || ( cbGalleryPost.length ) ) {
            cbFisFSOffTop = cbPostFeaturedImage.offset().top;
            cbWindowHeightTwo =  cbWindowHeight - cbFisFSOffTop;
        }

        cbFisFS.css( 'height', cbWindowHeightTwo );
        if ( ! cbBody.hasClass('cb-stuck') ) {
            if ( cbNavBar.length ) {
                if  ( cbWindowWidth > 767 ) {
                    cbNavBar.css( 'height', '' );
                    cbMenuHeight = cbNavBar.outerHeight();
                    cbNavBar.css( 'height', cbMenuHeight );
                }
            }
            
        }
        
        cbModFs.each( function() {
            var cbThis = $(this),
            cbWindowWidth = cbWindow.width();
            cbThis.css( { 'margin-left': ( ( cbContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
        });

         cbImagesAlignNone.each( function() {

            var cbThis = $(this);
           
            if ( cbBody.hasClass( cbScripts.cbFsClass ) ) {

                if ( cbThis.hasClass('wp-caption') ) {
                    var cbThisImg = cbThis.find('img');

                    if  ( cbThisImg.hasClass( 'size-full' ) ) {
                            
                        if ( cbBodyRTL === true ) {
                            cbThis.css( { 'margin-right': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' }).addClass('cb-fs-embed');
                        } else {
                            cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' }).addClass('cb-fs-embed');
                        }
                        cbThis.add(cbThisImg).css( 'width', cbWindowWidth );
                    }

                } else if ( cbThis.hasClass( 'size-full' ) ) {

                    if ( cbBodyRTL === true ) {
                        cbThis.css( { 'margin-right': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
                    } else {
                        cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });
                    }

                }
            }

        });  

    });

    var cbVote = $('#cb-vote'),
        cbCriteriaAverage = $('.cb-criteria-score.cb-average-score'),
        cbVoteCriteria = cbVote.find('.cb-criteria'),
        cbYourRatingText = cbVoteCriteria.attr('data-cb-text'),
        cbVoteOverlay = cbVote.find('.cb-overlay'),
        cbExistingOverlaySpan,
        cbNotVoted,
        cbExistingOverlay,
        cbNotVote;

    if  ( cbVoteOverlay.length ) {

        cbExistingOverlaySpan = cbVoteOverlay.find('span');
        cbNotVoted = cbVote.not('.cb-voted').find('.cb-overlay');
        cbExistingOverlay = cbExistingOverlaySpan.css('width');

    } else {

        cbVoteOverlay = cbVote.find('.cb-overlay-stars');
        cbNotVote = cbNotVoted = cbVote.not('.cb-voted').find('.cb-overlay-stars');
        cbExistingOverlaySpan = cbVoteOverlay.find('span');
        cbExistingOverlay = cbExistingOverlaySpan.css('width');

        if (cbExistingOverlay !== '125px') {  cbExistingOverlaySpan.addClass('cb-zero-stars-trigger'); }
    }

    var cbExistingScore = cbCriteriaAverage.text(),
        cbExistingVoteLine = cbVoteCriteria.html();

    cbNotVoted.on('mousemove click mouseleave mouseenter', function(e) {
        
        var cbParentOffset = $(this).parent().offset(),
            cbStarOffset = $(this).offset(),
            cbFinalX,
            cbBaseX,
            cbWidthDivider = cbVote.width() / 100,
            cbStarWidthDivider = cbVoteOverlay.width() / 100;

        if ( cbVote.hasClass('stars') ) {

            if (Math.round(cbStarOffset.left) <= e.pageX) {

                cbBaseX = Math.round( ( ( e.pageX - Math.round(cbStarOffset.left) ) / cbStarWidthDivider )   );
                cbFinalX = ( Math.round( cbBaseX * 10 / 20) / 10 ).toFixed(1);


                if ( cbFinalX < 0 ) { cbFinalX = 0; }
                if ( cbFinalX > 5 ) { cbFinalX = 5; }

                if ( cbBodyRTL === true ) {
                    cbOverlaySpan = cbBaseX ;
                } else {
                    cbOverlaySpan = ( 100 - cbBaseX );
                }
            }

        } else {

            cbBaseX = Math.ceil((e.pageX - cbParentOffset.left) / cbWidthDivider);
            if ( cbBodyRTL === true ) {
                cbOverlaySpan = ( 100 - cbBaseX );
            } else {
                cbOverlaySpan = cbBaseX;
            }
        }  

        if ( cbVote.hasClass('points') ) {
            cbFinalX = (cbBaseX / 10).toFixed(1);
            cbCriteriaAverage.text(cbFinalX);
        } else if ( cbVote.hasClass('percentage') ) {
            cbFinalX = cbBaseX + '%';
            cbCriteriaAverage.text(cbFinalX);
        }

        if ( cbExistingOverlaySpan.hasClass('cb-bar-ani') ) { cbExistingOverlaySpan.removeClass('cb-bar-ani'); }
        if ( cbExistingOverlaySpan.hasClass('cb-bar-ani-stars') ) { cbExistingOverlaySpan.removeClass('cb-bar-ani-stars').css( 'width', (100 - (cbBaseX) +'%') ); }
        if ( cbOverlaySpan > 100 ) { cbOverlaySpan = 100; }
        if ( cbOverlaySpan < 1 ) { cbOverlaySpan = 0; }

        cbExistingOverlaySpan.css( 'width', cbOverlaySpan + '%' );

        if ( e.type == 'mouseenter' ) {
            cbVoteCriteria.fadeOut(75, function () {
                $(this).fadeIn(75).text( cbYourRatingText );
            });
        }
        if ( e.type == 'mouseleave' ) {
            cbExistingOverlaySpan.animate( {'width': cbExistingOverlay}, 300);
            cbCriteriaAverage.text(cbExistingScore);
            cbVoteCriteria.fadeOut(75, function () {
                $(this).fadeIn(75).html(cbExistingVoteLine);
            });
        }

        if ( e.type == 'click' ) {
            cbNonce = cbVote.attr('data-cb-nonce');
            if ( cbVote.hasClass('points') ) { cbFinalX = cbFinalX * 10; }
            if ( cbVote.hasClass('stars') ) { cbFinalX = cbFinalX * 20; }            

            cbParentOffset = $(this).parent().offset();

            cbVoteOverlay.off('mousemove click mouseleave mouseenter');

            $.ajax({
                type : "POST",
                data : { action: 'cb_a_s', cburNonce: cbNonce, cbNewScore: parseInt(cbFinalX), cbPostID: cbScripts.cbPostID },
                url: cbScripts.cbUrl,
                dataType:"json",
                success : function( msg ){

                    var cb_score = msg[0],
                        cbVotesText = msg[2];
                        
                    cbVoteCriteria.fadeOut(550, function () {  $(this).fadeIn(550).html(cbExistingVoteLine).find('.cb-votes-count').html(cbVotesText); });

                    if ( ( cb_score !== '-1' ) && ( cb_score !=='null' ) ) {

                        if ( cbVote.hasClass('points') ) {

                            cbCriteriaAverage.html( (cb_score / 10).toFixed(1) );

                        } else if ( cbVote.hasClass('percentage') ) {

                            cbCriteriaAverage.html(cb_score + '%');

                        } else {
                            cb_score = 100 - cb_score;
                    }
                        cbExistingOverlaySpan.css( 'width', cb_score +'%' );
                        cbVote.addClass('cb-voted cb-tip-bot').off('click');
                    }

                    cbVote.tipper({
                        direction: 'bottom',
                        follow: true
                    });

                    if ( cookie.enabled() ) {
                        cookie.set( {cb_post_left_rating: '1' }, { expires: 28, });
                    }

                },
                error : function(jqXHR, textStatus, errorThrown) {
                    console.log("cbur " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });

            return false;
        }
    });
})(jQuery);