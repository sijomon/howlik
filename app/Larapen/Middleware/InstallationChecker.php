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

namespace App\Larapen\Middleware;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallationChecker
{
    public function handle($request, Closure $next)
    {
        // Do not check the installation if it is already installed or being installed
        if ($request->segment(1) == 'install' or $this->alreadyInstalled()) {
            return $next($request);
        }
        
        // Check Installation Setup
        try {
            $tablesExists = true;
            
            // Check if .env file exists
            if (!$this->envFileExists()) {
                $tablesExists = false;
            }
            
            // Check if all database tables exists
            $namespace = 'App\\Larapen\\Models\\';
            $modelsPath = app_path('Larapen/Models');
            $modelFiles = array_filter(File::glob($modelsPath . '/' . '*'), 'is_file');
            
            if (count($modelFiles) > 0) {
                foreach ($modelFiles as $filePath) {
                    $filename = last(explode('/', $filePath));
                    $modelname = head(explode('.', $filename));
                    
                    if (!str_contains($filename, '.php') or $modelname == 'BaseModel') {
                        continue;
                    }
                    
                    eval('$model = new ' . $namespace . $modelname . '();');
                    if (!Schema::hasTable($model->getTable())) {
                        $tablesExists = false;
                    }
                }
            }
        } catch (\Exception $e) {
            $tablesExists = false;
        }
        
        // Go to install proccess
        if (!$tablesExists) {
            return redirect('/install');
        }
        
        return $next($request);
    }
    
    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
    
    public function envFileExists()
    {
        return file_exists(base_path('.env'));
    }
}
