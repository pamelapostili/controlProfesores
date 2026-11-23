
<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150'
    ]) }}
    style="background-color: #657d43;"
    onmouseover="this.style.backgroundColor='#536737'"
    onmouseout="this.style.backgroundColor='#657d43'"
    onmousedown="this.style.backgroundColor='#45572e'"
    onmouseup="this.style.backgroundColor='#536737'"
>
    {{ $slot }}
</button>
