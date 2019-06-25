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

namespace App\Http\Controllers\Account;

use App\Larapen\Events\AdWasDeleted;
use App\Larapen\Helpers\Arr;
use App\Larapen\Helpers\Search;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Category;
use App\Larapen\Models\SavedAd;
use App\Larapen\Models\SavedSearch;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\View;
use Torann\LaravelMetaTags\Facades\MetaTag;

class AdsController extends AccountBaseController
{
    public function getMyAds()
    {
        $data = array();
        $data['ads'] = $this->my_ads->get();
        $data['type'] = 'myads';
        
        // Meta Tags
        MetaTag::set('title', t('My ads'));
        MetaTag::set('description', t('My ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getArchivedAds(HttpRequest $request)
    {
        // If repost
        if ($request->segment(4) == 'repost') {
            $id = $request->segment(5);
            $res = false;
            if (is_numeric($id) and $id > 0) {
                $res = Ad::find($id)->update(['archived' => 0]);
            }
            if (!$res) {
                flash()->error(t("The repost has failed. Please try again."));
            } else {
                flash()->success(t("The repost has done successfully."));
            }
            
            return redirect($this->lang->get('abbr') . '/account/' . $request->segment(3));
        }
        
        $data = array();
        $data['ads'] = $this->archived_ads->get();
        
        // Meta Tags
        MetaTag::set('title', t('My archived ads'));
        MetaTag::set('description', t('My archived ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getFavouriteAds()
    {
        $data = array();
        $data['ads'] = $this->favourite_ads->get();
        
        // Meta Tags
        MetaTag::set('title', t('My favourite ads'));
        MetaTag::set('description', t('My favourite ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getPendingApprovalAds()
    {
        $data = array();
        $data['ads'] = $this->pending_ads->get();
        
        // Meta Tags
        MetaTag::set('title', t('My pending approval ads'));
        MetaTag::set('description', t('My pending approval ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getSavedSearch(HttpRequest $request)
    {
        $data = array();
        
        // Get QueryString
        $tmp = parse_url(qsurl(Request::url(), Request::all()));
        $query_string = (isset($tmp['query']) ? $tmp['query'] : 'false');
        
        // CATEGORIES COLLECTION
        $cats = Category::where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $cats = collect($cats)->keyBy('translation_of');
        View::share('cats', $cats);
        
        // Search
        $saved_search = SavedSearch::where('user_id', $this->user->id)->orderBy('created_at', 'DESC')->get();
        
        if (collect($saved_search)->keyBy('query')->keys()->contains($query_string)) {
            if (!is_null($saved_search) and count($saved_search) > 0) {
                $search = new Search($request, $this->country, $this->lang);
                $data = $search->fechAll();
            }
        }
        $data['saved_search'] = $saved_search;
        
        // Meta Tags
        MetaTag::set('title', t('My saved search'));
        MetaTag::set('description', t('My saved search on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.saved-search', $data);
    }
    
    public function delete(HttpRequest $request)
    {
        // Get Entries ID
        $ids = [];
        if ($request->has('ad')) {
            $ids = $request->get('ad');
        } else {
            $id = $request->segment(5);
            if (!is_numeric($id) and $id <= 0) {
                $ids = [];
            } else {
                $ids[] = $id;
            }
        }
        
        // Delete
        $nb = 0;
        if ($request->segment(3) == 'favourite') {
            $saved_ads = SavedAd::where('user_id', $this->user->id)->whereIn('ad_id', $ids);
            if (!is_null($saved_ads)) {
                $nb = $saved_ads->delete();
            }
        } elseif ($request->segment(3) == 'saved-search') {
            $nb = SavedSearch::destroy($ids);
        } else {
            foreach ($ids as $id) {
                $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->find($id);
                if (!is_null($ad)) {
                    $tmp_ad = Arr::toObject($ad->toArray());
                    
                    // Delete Ad
                    $nb = $ad->delete();
                    
                    // Send an Email confirmation
                    Event::fire(new AdWasDeleted($tmp_ad));
                }
            }
        }
        
        // Confirmation
        if ($nb == 0) {
            flash()->error(t("No deletion is done. Please try again."));
        } else {
            $count = count($ids);
            if ($count > 1) {
                flash()->success(t("x ads has been deleted successfully.", ['count' => $count]));
            } else {
                flash()->success(t("1 ad has been deleted successfully."));
            }
        }
        
        return redirect($this->lang->get('abbr') . '/account/' . $request->segment(3));
    }
}
