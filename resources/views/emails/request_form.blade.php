@extends('emails.layouts.default')

@section('content')
  <tr>
    <td align="center" style="padding-top: 35px;">
      <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
        <tbody>
        <tr>
          <td
            style="padding-bottom: 16px; font-size: 17px; line-height: 22px;  font-family:Verdana, Arial, sans-serif;  color:#000000; text-align: left;">
            {!! str_replace('&&', $first_name . ' ' . $second_name, $langSt($params['request_form_text']['key'])) !!}
          </td>
        </tr>
        <tr>
          <td
            style="color:#000000;  font-family:Verdana, Arial, sans-serif; font-size:15px; line-height: 21px;">

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
            @lang('main.first_name'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($first_name) ? '-' : $first_name }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.second_name'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($second_name) ? '-' : $second_name }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.i_m_interested_in'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @if($interested === 1)
              @lang('main.buying_a_family_home')
            @elseif($interested === 2)
              @lang('main.investing_in_a_new_build')
            @elseif($interested === 3)
              @lang('main.investing_in_development_project')
            @else
              @lang('main.renting_an_apartment')
            @endif
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.preferred_number_of_bedrooms_is'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($bedrooms) ? '-' : $bedrooms }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.my_ideal_property_will_be_located_in'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($location) ? '-' : $location }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.i_ll_consider_options_between'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($price_from) ? '-' : $price_from }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main._and'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($price_to) ? '-' : $price_to }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.please_call_me_on_my_mobile_phone'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($phone_number) ? '-' : $phone_number }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.the_best_time_to_call_me_is'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($time_to_call) ? '-' : $time_to_call }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.i_currently_live_in'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {{ empty($city) ? '-' : $city }}
          </td>
        </tr>

        <tr>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            @lang('main.my_email_is'):
          </td>
          <td width="50%"
            style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
            {!! empty($email) ? '-' : "<a style=\"color: #332243\">$email</a>" !!}
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
