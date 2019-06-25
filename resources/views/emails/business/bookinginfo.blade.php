@extends('emails.layouts.master')
@section('title', $title)

@section('content')
<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;" bgcolor="#f6f6f6">
<tbody>
<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">&nbsp;</td>
<td class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;" bgcolor="#FFFFFF"><!-- content -->
<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; display: block; max-width: 600px; margin: 0 auto; padding: 0;">
<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
<tbody>
<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
  @lang('mail.<h1><font size="4">Dear :biz_owner,</font></h1><p>New reservation request has been received on your business <b>:biz_link</b>.</p><p>Please visit :your_orders on Howlik.com.</p><br/><br/>Thanks,<br/><br/>The :site_url Team.', ['biz_owner' => $template['biz_owner'], 'biz_link' => $template['biz_link'], 'your_orders' => $template['your_orders'], 'site_url' => $template['site_url']])
</td>
</tr>
</tbody>
</table>
</div>
<!-- /content --></td>
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">&nbsp;</td>
</tr>
</tbody>
</table>
@endsection
