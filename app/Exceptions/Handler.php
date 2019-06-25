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

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prologue\Alerts\Facades\Alert;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];
    
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }
    
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
		$sd = CountryLocalization::findCountry();
        // DB Error
        if ($e instanceof \PDOException) {
            /*
             * DB Connection Error:
             * http://dev.mysql.com/doc/refman/5.7/en/error-messages-server.html
             */
            $dbErrorCodes = [
                'mysql' => ['1042', '1044', '1045', '1046', '1049'],
                'standardized' => ['08S01', '42000', '28000', '3D000', '42000', '42S22'],
            ];
            $tableErrorCodes = [
                'mysql' => ['1051', '1109', '1146'],
                'standardized' => ['42S02'],
            ];
            
            // Database errors
            if (in_array($e->getCode(), $dbErrorCodes['mysql']) or in_array($e->getCode(), $dbErrorCodes['standardized'])) {
                $msg = '';
                $msg .= '<html><head><title>SQL Error</title></head><body>';
                $msg .= '<pre>';
                $msg .= '<h3>SQL Error</h3>';
                $msg .= '<br>Code error: ' . $e->getCode() . '.';
                $msg .= '<br><br><blockquote>' . $e->getMessage() . '</blockquote>';
                $msg .= '</pre>';
                $msg .= '</body></html>';
                echo $msg;
                exit();
            }
            
            // Tables and fields errors
            if (in_array($e->getCode(), $tableErrorCodes['mysql']) or in_array($e->getCode(), $tableErrorCodes['standardized'])) {
                $msg = '';
                $msg .= '<html><head><title>Installation - LaraClassified</title></head><body>';
                $msg .= '<pre>';
                $msg .= '<h3>There were errors during the installation process</h3>';
                $msg .= 'Some tables in the database are absent.';
                $msg .= '<br><br><blockquote>' . $e->getMessage() . '</blockquote>';
                $msg .= '<br>1/ Perform the database installation manually with the sql files:';
                $msg .= '<ul>';
                $msg .= '<li><code>/database/sql/schema.sql</code> (required)</li>';
                $msg .= '<li><code>/database/sql/data/required/app-data.sql</code> (required)</li>';
                $msg .= '<li><code>/database/sql/data/required/ca-cities.sql</code> (required during installation)</li>';
                $msg .= '<li><code>/database/sql/data/geonames/all.sql</code> (optional)</li>';
                $msg .= '</ul>';
                $msg .= '<br>2/ Or perform a resettlement:';
                $msg .= '<ul>';
                $msg .= '<li>Delete the installation backup file at: <code>/storage/installed</code> (required before re-installation)</li>';
                $msg .= '<li>and reload this page -or- go to install URL: <a href="' . url('install') . '">' . url('install') . '</a>.</li>';
                $msg .= '</ul>';
                $msg .= '<br>BE CAREFUL: If your site is already in production, you will lose all your data in both cases.';
                $msg .= '</body></html>';
                echo $msg;
                exit();
            }
        }
        
        /*
        // App's key Encryption Error
        // @todo: Check that this is exactly an encryption error.
        if ($e instanceof \RuntimeException)
        {
            $msg = '';
            $msg .= '<pre>';
            $msg .= '<h3>Your App\'s key encryption failed</h3>Please update your App\'s key with APP_KEY var in the <code>/.env</code> file.';
            $msg .= '<br>This key must consist of 32 alphanumeric characters of a string.';
            $msg .= '</pre>';
            echo $msg;
            exit();
        }
        */
        
        /*
        // HTTP Errors
        if ($e instanceof HttpException) {
            if (in_array($e->getStatusCode(), [404, 503]))
            {
                // 404 : Page not found
                // 503 : Maintenance mode
                return response()->view('errors.'.$e->getStatusCode(), ['e' => $e], $e->getStatusCode());
            }
        }

        // Model not found
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        // View don't found
        if ($e instanceof \InvalidArgumentException) {
            //abort(404);
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        */
        
        // Token error crash message
        if ($e instanceof TokenMismatchException) {
            $message = "The session has expired after a longtime. Please try now.";
            flash()->error($message); // front
            Alert::error($message)->flash(); // admin
            if (!str_contains(URL::previous(), 'CsrfToken')) {
                return redirect(URL::previous() . '?error=CsrfToken')->withInput();
            } else {
                return redirect(URL::previous())->withInput();
            }
        }
        
        if ($e instanceof MethodNotAllowedHttpException) {
            $message = "Opps! Seems you use a bad request method. Please try again.";
            flash()->error($message);
            if (!str_contains(URL::previous(), 'MethodNotAllowed')) {
                return redirect(URL::previous() . '?error=MethodNotAllowed');
            } else {
                return redirect(URL::previous())->withInput();
            }
        }
        
        // Original Code
        return parent::render($request, $e);
    }
}
