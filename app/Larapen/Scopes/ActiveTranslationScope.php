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

namespace App\Larapen\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ActiveTranslationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Request::segment(1) == 'admin') {
            return $builder;
        }
        
        // Check parent activation
        $default_active_parents = DB::table($model->getTable() . ' as tb1')->where('tb1.translation_lang',
            'en')->whereNull('tb1.translation_of')->where('tb1.active', 1);
        
        $activeParents = DB::table($model->getTable() . ' as tb1')->join($model->getTable() . ' as tb2', function ($join) {
            $join->on('tb2.id', '=', 'tb1.translation_of');
            $join->on(function ($join) {
                $join->on('tb1.translation_of', '=', 'tb1.id');
            });
        })->where('tb1.active', 1)->union($default_active_parents)->get(['tb1.*']);
        
        
        // Get all active entity IDs which are active
        $activeIds = [];
        foreach ($activeParents as $parent) {
            if (is_null($parent->translation_of) or $parent->translation_of == '') {
                $activeIds[] = $parent->id;
            }
            
            $activeChildren = DB::table($model->getTable())->where('translation_of', $parent->id)->get();
            foreach ($activeChildren as $child) {
                $activeIds[] = $child->id;
            }
        }
        if (count($activeIds) > 0) {
            $activeIds = array_unique($activeIds);
        }
        
        return $builder->whereIn('id', $activeIds);
    }
}
