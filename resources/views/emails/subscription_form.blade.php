@extends('emails.layouts.default')

@section('content')
  <tr>
    <td align="center" style="padding-top: 35px;">
      <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
        <tbody>
        <tr>
          <td
            style="padding-bottom: 16px; font-size: 17px; line-height: 22px;  font-family:Verdana, Arial, sans-serif;  color:#000000; text-align: left;">
            {!! $langSt($params['subscribe_form_text']['key']) !!}
          </td>
        </tr>
        <tr>
          <td
            style="color:#000000;  font-family:Verdana, Arial, sans-serif; font-size:15px; line-height: 21px;">
            {{ $langSt($params['text_mail_selection_request']['key']) }}
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" style="padding-top: 36px;">
      <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
        <tbody>
        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.email'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {!! empty($email) ? '-' : "<a style=\"color: #332243\">$email</a>" !!}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.periodicity'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @if($periodicity === 1)
              @lang('main.once_a_week')
            @elseif($periodicity === 2)
              @lang('main.1_time_per_month')
            @else
              @lang('main.everyday')
            @endif
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.subscribe_to'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @if($type_subscribe === 1)
              @lang('main.objects')
            @elseif($type_subscribe === 2)
              @lang('main.blog_articles')
            @else
              @lang('main.objects_and_blog_articles')
            @endif
          </td>
        </tr>

        <tr>
          <td width="50%" style="border-bottom-width: 1px; border-bottom-color: #dcbaa1; border-bottom-style: dashed;"></td>
          <td width="50%" style="border-bottom-width: 1px; border-bottom-color: #dcbaa1; border-bottom-style: dashed;"></td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
@endsection
