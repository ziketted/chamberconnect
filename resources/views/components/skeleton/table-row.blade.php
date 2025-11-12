@props(['columns' => 4])

<tr class="animate-pulse">
    @for($i = 0; $i < $columns; $i++)
        <td class="px-6 py-4">
            <x-skeleton width="w-full" height="h-4" />
        </td>
    @endfor
</tr>