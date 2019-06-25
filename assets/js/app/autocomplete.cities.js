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
	
	$('input.loc_search').each(function(i, el) {	
		el = $(el);
		el.autocomplete({
			serviceUrl: siteUrl + '/ajax/autocomplete/city',
			type: 'post',
			async: false, 
			params: {
				'region': function() {
					return el.closest('form').find('#l_region').val();
				},
				'lc': languageCode,
				'city': $(this).val(),
				'_token': $('input[name=_token]').val()
			},
			minChars: 1,
			onSelect: function(suggestion) {
				$('#l_search').val(suggestion.data);
			}
		});
	});
	
	$('input.loc_search_mob').each(function(i, el) {	
		el = $(el);
		el.autocomplete({
			serviceUrl: siteUrl + '/ajax/autocomplete/city',
			type: 'post',
			async: false, 
			params: {
				'region': function() {
					return $('#l_region_mob').val();
				},
				'lc': languageCode,
				'city': $(this).val(),
				'_token': $('input[name=_token]').val()
			},
			minChars: 1,
			onSelect: function(suggestion) {
				$('#l_search').val(suggestion.data);
				$('#loc_search').val(suggestion.value);
			}
		});
	});
	
    /*$('input#loc_search').autocomplete({
        serviceUrl: siteUrl + '/ajax/autocomplete/city',
        type: 'post',
        params: {
			'region': function() {
				alert(this.element.attr('id'));
				alert($(this).closest('form').find('.l_region').val());
				return $(this).closest('form').find('.l_region').val();
			},
            'city': $(this).val(),
            '_token': $('input[name=_token]').val()
        },
        minChars: 1,
        onSelect: function(suggestion) {
            $('#l_search').val(suggestion.data);
        }
    });*/
	
});

