<table class="table table-borderless table-condensed">
    <tr>
        <th class="pl-0">{{ __('Products') }}:</th>
        <td>{{ format_price(Cart::total()) }}</td>
    </tr>
</table>

<h5>{{ __('Total') }}:</h5>
<h3>{{ format_price(Cart::total()) }}</h3>

<hr>
