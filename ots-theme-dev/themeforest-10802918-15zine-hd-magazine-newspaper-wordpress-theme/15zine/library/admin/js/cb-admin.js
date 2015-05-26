jQuery(document).ready(function($){
	'use strict';
    /* global jQuery, OT_UI, option_tree, ajaxurl, postL10n */

	var cbFinalScore = $('#cb_final_score'),
        cbGo = $('#cb_go');

	function cbScoreCalc() {

        var i = 0, cbTempTotal = 0;

        $( '#setting_cb_review_crits [id^="cb_review_crits_cb_cs_"]' ).each(function() {
            i +=1 ;
            cbTempTotal += parseFloat( $(this).val() );
            
        });
        var cbTotal = Math.round(cbTempTotal / i);

        $('#cb_final_score').val(cbTotal);

        if ( isNaN(cbTotal) ) { cbFinalScore.val(''); }

    }

    cbGo.find('.ot-numeric-slider-wrap').each(function() {
         var hidden = $('.ot-numeric-slider-hidden-input', this),
            value  = hidden.val(),
            helper = $('.ot-numeric-slider-helper-input', this);
        if ( ! value ) {
          value = hidden.data("min");
          helper.val(value);
        }

        cbGo.find('.ot-numeric-slider', this).slider({

            slide: function(event, ui) {
                hidden.add(helper).val(ui.value);
                cbScoreCalc();
            },
            change: function() {
                OT_UI.init_conditions();
                cbScoreCalc();
            }
        });
    });

    jQuery(cbGo).on('change', '.ot-numeric-slider-hidden-input', function() {
        cbScoreCalc();
    });

    $('#setting_cb_review_crits').on('click', '.option-tree-setting-remove', function(event) {

        event.preventDefault();
        if ( $(this).parents('li').hasClass('ui-state-disabled') ) {
          alert(option_tree.remove_no);
          return false;
        }

        var agree = confirm(option_tree.remove_agree);

        if (agree) {

            var list = $(this).parents('ul');
            OT_UI.remove(this);
            setTimeout( function() { 
                OT_UI.update_ids(list); 
                cbScoreCalc();
            }, 200 );
            
        }
        return false;
    });

    $('#tax_meta_class_nonce').before('<h2 id="cb-header">15Zine Options</h2><h3 id="cb-subhead">General Options</h3>');
    $('#nonce-delete-mupload_cb_bg_image_field_id').closest('.form-field').before('<h3 id="cb-subhead">15Zine Background Options</h3>');  

    var cbHpb = $('#cb_hpb'),
        cbSectionA = $('#setting_cb_section_a'),
        cbSectionB = $('#setting_cb_section_b'),
        cbSectionC = $('#setting_cb_section_c'),
        cbSectionF = $('#setting_cb_section_f'),
        cbSelectedAd = cbHpb.find('.option-tree-ui-radio-image-selected[title^="Ad"]').closest('.option-tree-setting-body'),
        cbSelectedModule = cbHpb.find('.option-tree-ui-radio-image-selected[title^="Mo"]').closest('.option-tree-setting-body'),
        cbSelectedSlider = cbHpb.find('.option-tree-ui-radio-image-selected[title^="Sl"]').closest('.option-tree-setting-body'),
        cbSelectedCustom = cbHpb.find('.option-tree-ui-radio-image-selected[title^="Cu"]').closest('.option-tree-setting-body'),
        cbSelectedGrid = cbHpb.find('.option-tree-ui-radio-image-selected[title^="Gr"]').closest('.option-tree-setting-body'),
        cbLoadPostInput = cbHpb.find($("[id^='cbraj_']")),
        cbLoadPostInputVals = cbLoadPostInput.val();

    cbSectionA.before('<div id="setting_cb_title" class="format-settings"><div class="format-setting-wrap"><div class="format-setting-label"><h3 class="label">15Zine Homepage Builder</h3></div><div class="list-item-description">All the sections below are optional, allowing you to build any type of homepage you want. Remember to set "Page Attributes: Template" to "15Zine Drag & Drop Builder" and <strong>GET CREATIVE!</strong></div></div></div>');

    cbSelectedAd.each(function () {

        var cbCurrentSection = $(this).closest("[id^=setting_cb_section]").attr('id'),
            cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1);
        $(this).cbSectionCode(cbCurrentSectionID, 'cbAd');

    });

    cbSelectedCustom.each(function () {

        var cbCurrentSection = $(this).closest("[id^=setting_cb_section]").attr('id'),
            cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1);
        $(this).cbSectionCode(cbCurrentSectionID, 'cbCode');

    });

    cbSelectedModule.each(function () {

        var cbCurrentSection = $(this).closest("[id^=setting_cb_section]").attr('id'),
            cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1);
        $(this).cbSectionCode(cbCurrentSectionID, 'cbModule');

    });

    cbSelectedSlider.each(function () {

        var cbCurrentSection = $(this).closest("[id^=setting_cb_section]").attr('id'),
            cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1);
        $(this).cbSectionCode(cbCurrentSectionID, 'cbSlider');

    });

    cbSelectedGrid.each(function () {

        var cbCurrentSection = $(this).closest("[id^=setting_cb_section]").attr('id'),
            cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1);
        $(this).cbSectionCode(cbCurrentSectionID, 'cbGrid');

    });

    cbLoadPostInput.each(function () {

        var cbCurrentPost = $(this),
            cbAllPosts = cbCurrentPost.val().split('<cb>'),
            cbCurrentPostPrev = cbCurrentPost.prev(),
            cbAllPostsLength = cbAllPosts.length;



        for ( var i = 0; i < cbAllPostsLength; i++ ) {
          if (cbAllPosts[i].trim()) {
            cbCurrentPostPrev.before('<span class="cb-post-added">' + cbAllPosts[i] + '</span>');
          }
        }

    });

    $(document).on('click', '.cb-post-added', function () {

            var cbCurrentPostAdded = $(this),
                cbCurrentParent = cbCurrentPostAdded.parent(),
                cbLastInput = $(':last-child', cbCurrentParent),
                cbCurrentText;

            cbCurrentPostAdded.remove();

            var cbLastTest = cbCurrentParent.find('.cb-post-added');
            cbLastInput.val( '' );

            cbLastTest.each(function () {
              cbCurrentText = $(this).text();
              var cbCurrentInputVal = cbLastInput.val();
              cbLastInput.val( cbCurrentInputVal + cbCurrentText + '<cb>' );
            });
    });

    cbHpb.find('.option-tree-ui-radio-image-selected[title="Module B"]').closest('.ui-state-default').addClass('cb-half-width');
    cbHpb.find('.option-tree-ui-radio-image-selected[title="Custom Code Half-Width"]').closest('.ui-state-default').addClass('cb-half-width');
    cbHpb.find('.option-tree-ui-radio-image-selected[title="Module Reviews Half-Width"]').closest('.ui-state-default').addClass('cb-half-width');
    cbHpb.find('.option-tree-ui-radio-image-selected[title="Ad: 336x280"]').closest('.ui-state-default').addClass('cb-half-width');

    cbSectionA.add(cbSectionB).add(cbSectionC).add(cbSectionF).on('click', '.option-tree-ui-radio-image', function() {

      var cbCurrentBlock = $(this).closest('.option-tree-setting-body'),
          cbCurrentSection = $(this).closest("[id^=setting_cb_section]").parent().closest("[id^=setting_cb_section]").attr('id'),
          cbCurrentSectionID = cbCurrentSection.substr(cbCurrentSection.length - 1),
          cbCurrentModuleTitle = $(this).attr('title'),
          cbCurrentModuleTitleTrim = cbCurrentModuleTitle.substring(0, 2),
          cbCurrentModule = '';

      if ( cbCurrentModuleTitleTrim === 'Ad' )  {
        cbCurrentModule = 'cbAd';
      } else if ( cbCurrentModuleTitleTrim === 'Mo' ) {
        cbCurrentModule = 'cbModule';
      } else if ( cbCurrentModuleTitleTrim === 'Sl' )  {
        cbCurrentModule = 'cbSlider';
      } else if ( cbCurrentModuleTitleTrim === 'Gr' ) {
        cbCurrentModule = 'cbGrid';
      } else if ( cbCurrentModuleTitleTrim === 'Cu') {
        cbCurrentModule = 'cbCode';
      }

      cbCurrentBlock.cbSectionCode(cbCurrentSectionID, cbCurrentModule);

       if ( ( cbCurrentModuleTitle === 'Ad: 336x280') || ( cbCurrentModuleTitle === 'Module Reviews Half-Width') || ( cbCurrentModuleTitle === 'Module B') || ( cbCurrentModuleTitle === 'Custom Code Half-Width') )  {
        $(this).closest('.ui-state-default').addClass('cb-half-width');
      } else {
        $(this).closest('.ui-state-default').removeClass('cb-half-width');
      }

    });

    var cbCatOffset = $(".at-select[name='cb_cat_offset']").closest('.form-field'),
        cbCatGridSlider = $(".at-select[name='cb_cat_featured_op']"),
        cbCatGridSliderValue = $(".at-select[name='cb_cat_featured_op'] option:selected").text();

    if ( cbCatGridSliderValue === 'Off' ) {
        cbCatOffset.hide();
    }

    cbCatGridSlider.change(function() {

        if ( this.value === 'Off' ) {
            cbCatOffset.slideUp();
        } else {
            cbCatOffset.slideDown();
        }

    });

});

jQuery('select[id^="widget-cb-popular-posts"]').on('change', function() {

    var cbInput = jQuery(this),
        cbInputChanger = cbInput.val(),
        cbDateFilter = cbInput.closest('p').next();

    if ( cbInputChanger == 'cb-comments' ) {
        cbDateFilter.slideUp();
    } else {
        cbDateFilter.slideDown();
    }

});

(function( $ ) {
 $.fn.cbSectionCode = function( cb_current_section ) {

    var cbCurrentBlock = $(this),
        cbTagInput = cbCurrentBlock.find($("[id^='cb_section_" + cb_current_section + "_ta']")),
        cbPostInput = cbCurrentBlock.find($("[id^='cbaj_']"));
        cbTagInput.suggest( ajaxurl + '?action=ajax-tag-search&tax=post_tag', { delay: 500, minchars: 2, multiple: true, multipleSep: postL10n.comma } );
        cbPostInput.suggest( ajaxurl + '?action=cb-ajax-post-search', { delay: 500, minchars: 2, multiple: true, multipleSep: ' ' } );

        cbPostInput.change(function() {

            var cbInputChange = $(this);
            setTimeout(function () {
                var cbPostInputVal = cbInputChange.val().trim(),
                    cbRealInput = cbInputChange.next(),
                    cbRealInputVal = cbRealInput.val();

                if ( cbPostInputVal.trim() ) {
                    cbInputChange.before( '<span class="cb-post-added">'+ cbPostInputVal +'</span>' );
                    cbRealInput.val( cbRealInputVal + '<cb>' + cbPostInputVal );
                    cbInputChange.val( '' );
                }
            }, 600);
        });

   


    return this;
    
    };

})( jQuery );