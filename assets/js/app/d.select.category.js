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

$(document).ready(function()
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		cache: false
	});

    /*$.ajaxSetup({ cache: false });*/

    /* On load */
	getSubCategories(siteUrl, languageCode, category, subCategory);
	checkResumeField(categoryType);

    /* On select */
    $('#parent').bind('click, change', function()
	{
		/* Get sub-categories */
		var category = $(this).val();
		getSubCategories(siteUrl, languageCode, category, 0);

		/* Check resume file field */
		var selectedCat = $(this).find('option:selected');
		var selectedCatType = selectedCat.data('type');
		checkResumeField(selectedCatType);

		/* Update 'parent_type' field */
		$('input[name=parent_type]').val(selectedCatType);
	});
});

function getSubCategories(siteUrl, languageCode, catId, defaultSubCatId)
{
	/* Check Bugs */
	if (typeof languageCode == 'undefined' || typeof catId == 'undefined')
	{
		/*alert('Error | Language: ' + languageCode + ' - Category: ' + catId + ' !');*/
		return false;
	}

	/* Dont make ajax request if any category has selected. */
	if (catId==0) {
		return false;
	}

	/* Make ajax call */
	$.ajax({
		method: 'POST',
		url: siteUrl + '/ajax/category/sub-categories',
		data: {
			'cat_id': catId,
			'selected_sub_cat_id': defaultSubCatId,
			'language_code': languageCode,
			'_token': $('input[name=_token]').val()
		}
	}).done(function(obj)
	{
		var targetSelectId = 'category';

		/* init. */
		$('#'+targetSelectId).find('option').remove().end().append('<option value="0"> ' + lang.select.subCategory + ' </option>').val('0');

		/* error */
		if (typeof obj.error != "undefined") {
			$('#'+targetSelectId).find('option').remove().end().append('<option value="0"> '+ obj.error.message +' </option>');
			$('#'+targetSelectId).closest('.form-group').addClass('has-error');
			return false;
		} else {
			$('#'+targetSelectId).closest('.form-group').removeClass('has-error');
		}

		if (typeof obj.data == "undefined") {
			return false;
		}

		/* Bind data into Select list */
		$.each(obj.data, function (key, item) {
			if (defaultSubCatId == item.tid) {
				$('#' + targetSelectId).append('<option value="' + item.tid + '" selected="selected">' + item.name + '</option>');
			} else
				$('#' + targetSelectId).append('<option value="' + item.tid + '">' + item.name + '</option>');
		});
	});

    return defaultSubCatId;
}

/**
 *  Set category fields (for Job Offer & Job Search)
 *  85 : Job Offer (cat_id in demo version)
 *  109 : Job Search (cat_id in demo version)
 */
function checkResumeField(categoryType)
{
	if (categoryType == 'job-offer') {
		$('#adTypeBloc label[for="ad_type2"]').show();
		$('#priceBloc label[for="price"]').html('Salary');
		$('#picturesBloc').hide();
		$('#resumeBloc').hide();
	} else if (categoryType == 'job-search') {
		$('#adTypeBloc input[value="1"]').attr('checked', 'checked');
		$('#adTypeBloc label[for="ad_type2"]').hide();
		$('#priceBloc label[for="price"]').html('Salary');
		$('#picturesBloc').hide();
		$('#resumeBloc').show();
	} else {
		$('#adTypeBloc label[for="ad_type2"]').show();
		$('#priceBloc label[for="price"]').html('Price')
		$('#picturesBloc').show();
		$('#resumeBloc').hide();
	}
}

