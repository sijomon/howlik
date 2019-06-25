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

namespace Larapen\LangFileManager\app\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use Backpack\LangFileManager\app\Services\LangFiles;
use Backpack\LangFileManager\app\Models\Language;
use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Larapen\LangFileManager\app\Http\Requests\LanguageRequest as StoreRequest;
use Larapen\LangFileManager\app\Http\Requests\LanguageRequest as UpdateRequest;

class LanguageCrudController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Language",
        "entity_name" => "language",
        "entity_name_plural" => "languages",
        "route" => "admin/language",
        
        // *****
        // COLUMNS
        // *****
        //
        // Define the columns for the table view as an array:
        //
        "columns" => [
            [
                'name' => 'name',
                'label' => "Language name"
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => "model_function",
                'function_name' => 'getActiveHtml',
            ],
            [
                'name' => 'default',
                'label' => "Default",
                'type' => "model_function",
                'function_name' => 'getDefaultHtml',
            ]
        ],
        "fields" => [
            [
                'name' => 'name',
                'label' => 'Language Name',
                'type' => 'text',
            ],
            [
                'name' => 'native',
                'label' => 'Native Name',
                'type' => 'text',
            ],
            [
                'name' => 'abbr',
                'label' => 'Code (ISO 639-1)',
                'type' => 'text',
            ],
            [
                'name' => 'locale',
                'label' => 'Locale Code (E.g. en_US)',
                'type' => 'text',
            ],
            [
                'name' => 'script',
                'label' => 'Script',
                'type' => 'text',
            ],
            [
                'name' => 'flag',
                'label' => 'Flag image (Optional)',
                'type' => 'browse'
            ],
            [
                'name' => 'active',
                'label' => 'Active',
                'type' => 'checkbox',
            ],
            [
                'name' => 'default',
                'label' => 'Default',
                'type' => 'checkbox',
            ],
        ],
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    
    public function showTexts(LangFiles $langfile, Language $languages, $lang = '', $file = 'site')
    {
        // SECURITY
        // check if that file isn't forbidden in the config file
        if (in_array($file, config('backpack.langfilemanager.language_ignore'))) {
            abort('403', 'This language file cannot be edited online.');
        }
        
        if ($lang) {
            $langfile->setLanguage($lang);
        }
        
        $langfile->setFile($file);
        
        $this->data['currentFile'] = $file;
        $this->data['currentLang'] = $lang ?: config('app.locale');
        $this->data['currentLangObj'] = Language::where('abbr', '=', $this->data['currentLang'])->first();
        $this->data['browsingLangObj'] = Language::where('abbr', '=', config('app.locale'))->first();
        $this->data['languages'] = $languages->orderBy('name')->get();
        $this->data['langFiles'] = $langfile->getlangFiles();
        $this->data['fileArray'] = $langfile->getFileContent();
        $this->data['langfile'] = $langfile;
        $this->data['title'] = "Translations";
        
        return view('langfilemanager::translations', $this->data);
    }
    
    public function updateTexts(LangFiles $langfile, Request $request, $lang = '', $file = 'site')
    {
        // SECURITY
        // check if that file isn't forbidden in the config file
        if (in_array($file, config('backpack.langfilemanager.language_ignore'))) {
            abort('403', 'This language file cannot be edited online.');
        }
        
        $message = trans('error.error_general');
        $status = false;
        
        if ($lang) {
            $langfile->setLanguage($lang);
        }
        
        $langfile->setFile($file);
        
        $fields = $langfile->testFields($request->all());
        if (empty($fields)) {
            if ($langfile->setFileContent($request->all())) {
                \Alert::success("Saved")->flash();
                $status = true;
            }
        } else {
            $message = trans('admin.language.fields_required');
            \Alert::error("Please fill all fields")->flash();
        }
        
        return redirect()->back();
    }
}
