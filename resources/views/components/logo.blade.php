@props([
    'label' => ''
])

<a class="text-white" style="display: flex; flex-direction: column; align-items: center;">
    <img 
        src="{{ Vite::asset('resources/images/agendamake.png') }}" 
        alt="Logo da agendamake MakeUp" 
        class="brand-image rounded-3"
        style="width: 200px; height: 160px; margin-bottom: 10px;"
    >
    {{-- <span><b>Gleyce</b>MakeUp</span> --}}
</a>