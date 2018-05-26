<table border="0">
	<tr>
		<td>@lang('main.name'): </td>
		<td>{{ empty($name) ? '-' : $name }}</td>
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
		<td>@lang('main.message'): </td>
		<td>{{ empty($message_s) ? '-' : $message_s }}</td>
	</tr>

	<tr>
		<td>@lang('main.link_to_cv'): </td>
		<td>{!! empty($file) ? '-' : '<a href="' . $file . ' ">' . __('main.link_to_cv') .'</a>' !!}</td>
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
