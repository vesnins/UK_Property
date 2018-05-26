<table border="0">
	<tr>
		<td>@lang('main.name'): </td>
		<td>{{ empty($name) ? '-' : $name }}</td>
	</tr>

	<tr>
		<td>@lang('main.position'): </td>
		<td>{{ empty($position) ? '-' : $position }}</td>
	</tr>

	<tr>
		<td>@lang('main.phone'): </td>
		<td>{{ empty($telephone) ? '-' : $telephone }}</td>
	</tr>

	<tr>
		<td>@lang('main.e_mail'): </td>
		<td>{{ empty($mail) ? '-' : $mail }}</td>
	</tr>

	<tr>
		<td>@lang('main.address_of_the_villa'): </td>
		<td>{{ empty($villaAddress) ? '-' : $villaAddress }}</td>
	</tr>

	<tr>
		<td>@lang('main.site_or_link_to_photos'): </td>
		<td>{{ empty($siteLink) ? '-' : $siteLink }}</td>
	</tr>

	<tr>
		<td>@lang('main.where_did_you_find_out_about_us'): </td>
		<td>{{ empty($source) ? '-' : $source }}</td>
	</tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
	<tbody>
	<tr>
		<td style="height: 20px; font-size: 20px; line-height: 20px;">
			<img width="20" height="20" title="OK" alt="OK" src="{{ env('APP_URL') }}/images/check.png"
				style="border:none; max-width: 20px; height: auto; max-height: 20px;">
		</td>
		<td
			style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left;">
			@lang('main.security_policy_text') <a href="{{ env('APP_URL') }}/privacy-policy"
				target="_blank"
				style="font-size: 15px; line-height: 18px; font-family:Verdana, Arial, sans-serif; color:#30343f; text-decoration: underline;">security
				police</a>
		</td>
	</tr>
	</tbody>
</table>