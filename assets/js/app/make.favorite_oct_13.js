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

    /* Search Left Sidebar : Categories & Sub-categories */
    $('#sub_cat_list h5 a').click(function()
    {
        $('#sub_cat_list').hide();
        $('#cat_list').show();
        return false;
    });

    /* Save Ad */
    $('.make-favorite').click(function(){
        saveAd(siteUrl, this);
    });

    /* Save search */
    $('#save_search').click(function(){
        saveSearch(siteUrl, this);
    });

});


function saveAd(siteUrl, elmt)
{
    $.ajax({
        method: 'POST',
        url: siteUrl + '/ajax/save/ad',
        data: {
            'ad_id': $(elmt).attr('id'),
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data) {
        if (typeof data.logged == "undefined") {
            return false;
        }
        if (data.logged == '0') {
            alert(lang.loginToSaveAd);
            window.location.replace(data.loginUrl);
            window.location.href = data.loginUrl;
            return false;
        }
        /* Decoration */
        if (data.status==1) {
            if ($(elmt).hasClass('btn')) {
                $('#' + data.adId).removeClass('btn-default').addClass('btn-success');
            } else {
                $(elmt).html('<i class="fa fa-heart"></i> Remove favorite');
            }
        } else {
            if ($(elmt).hasClass('btn')) {
                $('#' + data.adId).removeClass('btn-success').addClass('btn-default');
            } else {
                $(elmt).html('<i class="fa fa-heart"></i> Save ad');
            }
        }
        return false;
    });
    return false;
}

function saveSearch(siteUrl, elmt)
{
    var url         = $(elmt).attr('name');
    var countAds    = $(elmt).attr('count');

    $.ajax({
        method: 'POST',
        url: siteUrl + '/ajax/save/search',
        data: {
            'url': url,
            'count_ads': countAds,
            '_token': $('input[name=_token]').val()
        }
    }).done(function(data) {
        if (typeof data.logged == "undefined") {
            return false;
        }
        if (data.logged == '0') {
            alert(lang.loginToSaveSearch);
            window.location.replace(data.loginUrl);
            window.location.href = data.loginUrl;
            return false;
        }
        if (data.status==1) {
            alert(lang.confirmationSaveSearch);
        } else {
            alert(lang.confirmationRemoveSaveSearch);
        }
        return false;
    });
    return false;
}