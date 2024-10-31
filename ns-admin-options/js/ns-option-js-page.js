jQuery( document ).ready(function($) {
	racScrollToAnchor('rac-table-anchor');
	
	if($('#ns_rac_report_all_entries').is(':checked')) {
		$('#rac_report_from, #rac_report_to').prop('disabled', true);
		$('#ns_rac_users').prop('disabled', true);
		$('#ns_rac_filter_4_status').prop('disabled', true);
	}
	
	/*On selecting the 'all entries' checkbox need to deactivate the daterange inputs*/
	$('#ns_rac_report_all_entries').change(function() {
        if(this.checked) {
			$('#rac_report_from, #rac_report_to').prop('disabled', true);ns_rac_users
			$('#ns_rac_users').prop('disabled', true);
			$('#ns_rac_filter_4_status').prop('disabled', true);
        }
		else{
			$('#rac_report_from, #rac_report_to').prop('disabled', false);
			$('#ns_rac_users').prop('disabled', false);
			$('#ns_rac_filter_4_status').prop('disabled', false);
		}
    });
	
	/*Template selection. Add to hidden input the value and setting border color*/
	$('.rac_email_template').click(
		function(){ 
			$('.rac_email_template').css('border', '2px solid #fff');
			$('#rac_template_selected_hidden').val(this.id);
			$(this).css('border', '2px solid #6BAA01');
		}
	);
	
	/*On selecting email template color need to change the template previews background with the selected color*/
	$('#ns-rac-template-color-picker').change(
		function(){ 
			var colorValue = $(this).val();
			$('.rac_email_template').css('background-color', colorValue);
		}
	);
});


function racScrollToAnchor(aid){
	if (jQuery("a[name='"+ aid +"']").length) {
	    var aTag = jQuery("a[name='"+ aid +"']");
	    jQuery('html,body').scrollTop( aTag.offset().top );
	}
}
