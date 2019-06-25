@extends('emails.layouts.master')
@section('title', trans('mail.Your ad ":title" on :app_name', ['title' => $ad->title, 'app_name' => mb_ucfirst(config('settings.app_name'))]))

@section('content')
<table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;">
<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 600px !important; Margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">
<!-- content -->
<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; display: block; max-width: 600px; margin: 0 auto; padding: 0;">
<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">{!! nl2br($msg->message) !!}<br><br>@lang('mail.<strong>Contact Information :</strong><br>Name : :name<br>Email address : :email<br>Phone number : :phone<br><br>This email was sent to you about the ad ":title" you filed on :domain : :urlAd<br><br>PS : The person who contacted you do not know your email as you will not reply.<br><br>Remember to always check the details of your contact person (name, address, ...) to ensure you have a contact in case of dispute. In general, choose the delivery of the item in hand.<br><br>Beware of enticing offers! Be careful with requests from abroad when you only have a contact email. The bank transfer by Western Union or MoneyGram proposed may well be artificial.<br><br>For more informations please consult our disclaimer page : :urlAntiScam<br><br>Thank you for your trust and see you soon,<br><br>The :domain Team<br>:domain<br><br><br>PS: This is an automated email, please don\'t reply.',
['name' => $msg->name, 'email' => $msg->email, 'phone' => $msg->phone, 'title' => mb_ucfirst($ad->title), 'urlAd' => lurl(slugify($ad->title).'/'.$ad->id.'.html'), 'urlAntiScam' => lurl(trans('routes.anti-scam')), 'countryDomain' => lurl('/'), 'domain' => ucfirst(getDomain())])</p>
</td>
</tr>
</table>
</div>
<!-- /content -->
</td>
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
</tr>
</table>
@endsection
