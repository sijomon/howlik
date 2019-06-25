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

/*
 * $(document).ready(function() {
 *  // executes when HTML-Document is loaded and DOM is ready
 *  alert("document is ready");
 * });
 *
 *  $(window).load(function() {
 *  // executes when complete page is fully loaded, including all frames, objects and images
 *  alert("window is loaded");
 * });
 *
 * window.onload = function () { alert("It's loaded!") }
 */

$(document).ready(function() {
    $.ajaxSetup({ cache: false });
	
    /* On load */
	
	//alert(countryCode);
	//setTimeout("alert(countryCode);", 2000);
    getLocation(siteUrl, countryCode, loc);
    if (hasChildren == 'yes') {
        getSubLocation(siteUrl, loc, subLocation);
        getCities(siteUrl, subLocation, city);
    } else {
        getSubLocation(siteUrl, loc, city);
    }

    /* On select */
    $('#country').bind('click, change', function(){ getLocation(siteUrl, $(this).val(), 0); });
    $('#location').bind('click, change', function(){ getSubLocation(siteUrl, $(this).val(), 0); });
    $('#sub_location').bind('click, change', function(){ getCities(siteUrl, $(this).val(), 0); });
});


function getLocation(siteUrl, countryId, defaultLocationId)
{
    if (countryId==0) return false;
	//alert(siteUrl);
	if(siteUrl==undefined){
		siteUrl = window.location.origin;
	}
	//alert(siteUrl + '/ajax/places/countries/');
    $.get(siteUrl + '/ajax/places/countries/' + countryId + '/locations', function(obj)
    {
        var targetSelectId = 'location';

        /* init. */
        $('#'+targetSelectId).find('option').remove().end().append('<option value="0"> ' + lang.select.loc + ' </option>').val('0');
        $('#sub_location').find('option').remove().end().append('<option value="0"> ' + lang.select.subLocation + ' </option>').val('0').removeClass('has-error').prop('disabled', false);
        $('#city').find('option').remove().end().append('<option value="0"> ' + lang.select.city + ' </option>').val('0');

        /* Bind data into Select list */
        populateSelectList(targetSelectId, obj, defaultLocationId);
    });

    return defaultLocationId;
}

function getSubLocation(siteUrl, locationId, defaultSubLocationId)
{
    if (locationId==0) return false;
    $.get(siteUrl + '/ajax/places/locations/' + locationId + '/sub-locations', function(obj)
    {
        var targetSelectId = 'sub_location';

        /* init. */
        $('#'+targetSelectId).find('option').remove().end().append('<option value="0"> ' + lang.select.subLocation + ' </option>').val('0');
        $('#city').find('option').remove().end().append('<option value="0"> ' + lang.select.city + ' </option>').val('0').removeClass('has-error');

        /* Bind data into Select list */
        populateSelectList(targetSelectId, obj, defaultSubLocationId);
    });

    return defaultSubLocationId;
}

function getCities(siteUrl, subLocationId, defaulCityId)
{
    if (subLocationId==0) return false;
    $.get(siteUrl + '/ajax/places/sub-locations/' + subLocationId + '/cities', function(obj)
    {
        var targetSelectId = 'city';

        /* init. */
        $('#'+targetSelectId).find('option').remove().end().append('<option value="0"> ' + lang.select.city + ' </option>').val('0');

        /* Bind data into Select list */
        populateSelectList(targetSelectId, obj, defaulCityId);
    });

    return defaulCityId;
}

/* Bind data into Select list */
function populateSelectList(targetSelectId, obj, defaultSelectedId)
{
    if (typeof obj.error != "undefined") {
        $('#'+targetSelectId).find('option').remove().end().append('<option value="0"> '+ obj.error.message +' </option>');
        $('#'+targetSelectId).closest('.form-group').addClass('has-error');
        return false;
    } else {
        $('#'+targetSelectId).closest('.form-group').removeClass('has-error');
    }

    var hasChildren = '';
    if (typeof obj.hasChildren != "undefined") {
        hasChildren = obj.hasChildren;
    }
    if (hasChildren != '') {
        if (hasChildren == 'yes') {
            $('#has_children').val('yes');
            $('#sub_location').prop('disabled', false);
        } else if (hasChildren == 'no') {
            $('#has_children').val('no');
            $('#sub_location').prop('disabled', 'disabled');
            if (targetSelectId == 'sub_location') {
                targetSelectId = 'city';
            }
            $('#city').find('option').remove().end().append('<option value="0"> ' + lang.select.city + ' </option>').val('0');
        }
    }

    if (typeof obj.data == "undefined") {
        return false;
    }
    $.each(obj.data, function (key, item) {
        if (defaultSelectedId == item.code) {
            $('#' + targetSelectId).append('<option value="' + item.code + '" selected="selected">' + item.name + '</option>');
        } else
            $('#' + targetSelectId).append('<option value="' + item.code + '">' + item.name + '</option>');
    });

    return defaultSelectedId;
}
