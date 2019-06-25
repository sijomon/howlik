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

namespace App\Larapen\Helpers\Payment;

use App\Larapen\Events\AdWasPosted;
use App\Larapen\Models\Ad;
use Illuminate\Http\Request as HttpRequest;
use App\Larapen\Helpers\Payment;
use App\Larapen\Models\Pack;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class Paypal extends Payment
{
    public static function postPayment(HttpRequest $request, Ad $ad)
    {
        // Get Pack infos
        $pack = Pack::find($request->input('pack'));
        
        // Don't make a payment if 'price' = 0 or null
        if (is_null($pack) or $pack->price <= 0) {
            return false;
        }
        
        $params = array(
            'payment_method' => $request->get('payment_method'),
            'cancelUrl' => url(parent::$lang->get('abbr') . '/create-ad/cancel-payment'),
            'returnUrl' => url(parent::$lang->get('abbr') . '/create-ad/success-payment'),
            'name' => $pack->name,
            'description' => $pack->name,
            'amount' => (!is_float($pack->price)) ? floatval($pack->price) : $pack->price,
            'currency' => $pack->currency_code,
        );
        
        Session::put('params', array_merge($params, ['ad_id' => $ad->id]));
        Session::save();
        
        try {
            $gateway = Omnipay::create('PayPal_Express');
            $gateway->setUsername(config('services.paypal.username'));
            $gateway->setPassword(config('services.paypal.password'));
            $gateway->setSignature(config('services.paypal.signature'));
            $gateway->setTestMode((config('services.paypal.mode') == 'live') ? false : true);
            
            $response = $gateway->purchase($params)->send();
            
            if ($response->isSuccessful()) {
                // Payment was successful: update database
                // print_r($response); // debug
            } elseif ($response->isRedirect()) {
                // Redirect to offsite payment gateway
                $response->redirect();
            } else {
                // Payment failed
                // echo $response->getMessage(); // debug
                
                // Delete Ad
                if (!is_null($ad)) {
                    $ad->delete();
                }
                
                // Return to form
                $msg = '';
                $msg .= parent::$msg['checkout']['error'];
                $msg .= '<br>' . $response->getMessage();
                flash()->error($msg);
                
                return false;
            }
        } catch (\Exception $e) {
            // Payment API error
            
            // Delete Ad
            if (!is_null($ad)) {
                $ad->delete();
            }
            
            Session::forget('params');
            
            // Return to Form
            flash()->error($e->getMessage());
            
            return false;
        }
    }
    
    public static function getSuccessPayment($params, $ad)
    {
        try {
            $gateway = Omnipay::create('PayPal_Express');
            $gateway->setUsername(config('services.paypal.username'));
            $gateway->setPassword(config('services.paypal.password'));
            $gateway->setSignature(config('services.paypal.signature'));
            $gateway->setTestMode((config('services.paypal.mode') == 'live') ? false : true);
            
            $response = $gateway->completePurchase($params)->send();
            $paypal_response = $response->getData(); // this is the raw response object
            
            if (isset($paypal_response['PAYMENTINFO_0_ACK']) && $paypal_response['PAYMENTINFO_0_ACK'] === 'Success') {
                // Send Confirmation Email
                if (config('settings.require_ads_activation') == 1 and !is_null($ad)) {
                    Event::fire(new AdWasPosted($ad));
                }
                
                // Successful transaction
                flash()->success(parent::$msg['checkout']['success']);
                
                return redirect(parent::$uri['success'])->with(['success' => 1, 'message' => parent::$msg['post']['success']]);
            } else {
                // Payment failed
                
                // Delete Ad
                if (!is_null($ad)) {
                    $ad->delete();
                }
                
                // Return to Form
                flash()->error(parent::$msg['checkout']['error']);
                
                return redirect(parent::$uri['form'] . '?error=payment')->withInput();
            }
        } catch (\Exception $e) {
            // Payment API error
            
            // Delete Ad
            if (!is_null($ad)) {
                $ad->delete();
            }
            
            // Return to Form
            flash()->error($e->getMessage());
            
            return redirect(parent::$uri['form'] . '?error=paymentApi')->withInput();
        }
    }
}
