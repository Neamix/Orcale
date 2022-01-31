<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<div class="logo"></div>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
