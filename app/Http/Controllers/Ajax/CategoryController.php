<?php
/**
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

namespace App\Http\Controllers\Ajax;

use App\Larapen\Models\Category;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request as HttpRequest;

class CategoryController extends FrontController
{
    /**
     * @param $parentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategories(HttpRequest $request)
    {
        $language_code = $request->input('language_code');
        $parent_id = $request->input('cat_id');
        //$selected_sub_cat_id = $request->input('selected_sub_cat_id');
        //$_token     		= $request->input('_token');
        
        // Get Sub-categories by category ID
        $sub_categories = Category::where('parent_id', $parent_id)->where('translation_lang', $language_code)->orderBy('lft')->get();
        
        // Select the parent category if his haven't any sub-categories
        if ($sub_categories->count() == 0) {
            $sub_categories = Category::where('id', $parent_id)->where('translation_lang', $language_code)->orderBy('lft')->get();
        }
        
        if ($sub_categories->count() == 0) {
            return response()->json(['error' => ['message' => "Error. Please select other location.",], 404]);
        }
        
        return response()->json(['data' => $sub_categories], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
