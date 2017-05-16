jQuery(window).load(function(){
    jQuery('.ult_countdown-dateAndTime').each(function(){
        var t = new Date(jQuery(this).html());
        var tz = jQuery(this).data('time-zone')*60;
        var tfrmt = jQuery(this).data('countformat');
		var labels_new = jQuery(this).data('labels');
		var new_labels = labels_new.split(",");
		var labels_new_2 = jQuery(this).data('labels2');
		var new_labels_2 = labels_new_2.split(",");
        var server_time = function(){          
          return new Date(jQuery(this).data('time-now'));
        }
        var ticked = function (a){
            jQuery(this).find('.ult_countdown-amount').css({'color':jQuery(this).data('tick-col'),'font-size':jQuery(this).data('tick-size')})
            jQuery(this).find('.ult_countdown-period').css({'font-size':jQuery(this).data('tick-p-size'),'color':jQuery(this).data('tick-p-col')})
            jQuery(this).find('.ult_countdown-amount').css({'border-color':jQuery(this).data('br-color'),'border-width':jQuery(this).data('br-size'),'border-style':jQuery(this).data('br-style'),'border-radius':jQuery(this).data('br-radius'), 'background':jQuery(this).data('bg-color'),'padding':jQuery(this).data('padd'),})
            if(jQuery(this).data('tick-style')=='bold'){
                jQuery(this).find('.ult_countdown-amount').css('font-weight','bold');
            }
            else if (jQuery(this).data('tick-style')=='italic'){
                jQuery(this).find('.ult_countdown-amount').css('font-style','italic');
            }
            else if (jQuery(this).data('tick-style')=='boldnitalic'){
                jQuery(this).find('.ult_countdown-amount').css('font-weight','bold');
                jQuery(this).find('.ult_countdown-amount').css('font-style','italic');
            }
            if(jQuery(this).data('tick-p-style')=='bold'){
                jQuery(this).find('.ult_countdown-period').css('font-weight','bold');
            }
            else if (jQuery(this).data('tick-p-style')=='italic'){
                jQuery(this).find('.ult_countdown-period').css('font-style','italic');
            }
            else if (jQuery(this).data('tick-p-style')=='boldnitalic'){
                jQuery(this).find('.ult_countdown-period').css('font-weight','bold');
                jQuery(this).find('.ult_countdown-period').css('font-style','italic');
        }
    }    
    if(jQuery(this).hasClass('ult-usrtz')){
        jQuery(this).ult_countdown({labels: new_labels, labels1: new_labels_2, until : t, format: tfrmt, padZeroes:true,onTick:ticked});
    }else{
        jQuery(this).ult_countdown({labels: new_labels, labels1: new_labels_2, until : t, format: tfrmt, padZeroes:true,onTick:ticked , serverSync:server_time});
    }
    });
    /* jQuery('body').click(function(){
        jQuery('.ult_countdown-dateAndTime').ult_countdown('destroy')  ;
        jQuery('.ult_countdown-dateAndTime').ult_countdown({until: new Date()})  ;
    })
   */
})