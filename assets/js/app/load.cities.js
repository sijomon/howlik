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

    if (stateId != 0) {
        changeCity(siteUrl, languageCode, stateId);
    }
    $('#region_state').change(function(){
        changeCity(siteUrl, languageCode, $(this).val());
    });

});

function changeCity(siteUrl, languageCode, stateId)
{
	/* Check Bugs */
    if (typeof languageCode == 'undefined' || typeof stateId == 'undefined')
    {
        //alert('Error | Language: ' + languageCode + ' - StateId: ' + stateId + ' !');
        return false;
    }

	/* Make ajax call */
    $.ajax({
        method: 'POST',
        url: siteUrl + '/ajax/state/cities',
        data: {
            'language_code': languageCode,
            'full_state_code': stateId,
            'curr_search': $('#curr_search').val(),
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data)
	{
        if (typeof data.stateCities == "undefined") {
            return false;
        }
        $('#select_state strong').html(data.selectState);
        $('#state_cities').html(data.stateCities);
        $('#region_state').prop('selected');
    });
}