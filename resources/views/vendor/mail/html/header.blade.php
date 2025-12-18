@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('assets/images/logo/merelogo.png') }}" class="logo" alt="{{ config('app.name') }}"
                style="max-height: 75px; width: auto;">
        </a>
    </td>
</tr>