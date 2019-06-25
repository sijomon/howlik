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
	
	$('input#friend-search').each(function(i, el) {	
		el = $(el);
		el.autocomplete({
			serviceUrl: siteUrl + '/ajax/search/user',
			type: 'post',
			params: {'_token': $('input[name=_token]').val()},
			minChars: 1,
			onSelect: function(users) {
				$('input#friend-search').val(value);
			}
		});
	});
	
});

