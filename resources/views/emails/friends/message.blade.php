@extends('emails.layouts.master')
@section('title', trans('mail.Welcome to :app_name :user_name', ['app_name' => config('settings.app_name'), 'user_name' => $user12['name']]))
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
                     <h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 20px; line-height: 1.2em; color: #111111; font-weight: bold; margin: 0 0 10px; padding: 0;">
					 @lang($userFrom .' has sent you a Message')</h3>
                     <!-- button -->
                     <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; margin: 20px 0 20px; padding: 0;">
                        <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                           <td><label style="font-weight: bold;font-style: inherit;font-size: 13px;">Subject : </label></td>
                           <p><?php print_r($sub);?></p>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                           <td><label style="font-weight: bold;font-style: inherit;font-size: 13px;">Message : </label></td>
                           <p><?php print_r($mess);?></p>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                           <td><a href="http://www.howlik.com/login"><button type="submit" style="width: 100%;float: left;background-color: #ec0d2c !important;border-color: #ec0d2c !important;color: #fff;border-radius: 4px;font-size: 16px;line-height: 1.471;text-align: center;cursor: pointer;font-family: inherit;padding: 3px 35px 7px;">Reply</button></a></td>
                        </tr>
                     </table>
                     <!-- /button -->
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