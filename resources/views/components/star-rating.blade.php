@if ($rating)
    @for ($i = 1; $i <= 5; $i++)
        <i class="{{ $i <= round($rating) ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
    @endfor
@else
    <p>No Rating!!</p>
@endif
