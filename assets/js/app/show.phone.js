/*
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

$(document).ready(function()
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.showphone').click(function(){
		showPhone(siteUrl);
	});

});


/**
 * Show Ad phone
 * @param siteUrl
 * @returns {boolean}
 */
function showPhone(siteUrl)
{
	return false; // Desactivated
	
	if ($('#ad_id').val()==0) {
		return false;
	}

	$.ajax({
		method: 'POST',
		url: siteUrl + '/ajax/ad/phone',
		data: {
			'ad_id': $('#ad_id').val(),
			'_token': $('input[name=_token]').val()
		}
	}).done(function(data) {
		if (typeof data.phone == "undefined") {
			return false;
		}
		$('.showphone').html('<i class=" icon-phone-1"></i> ' + data.phone);
		$('#ad_id').val(0);
	});
}