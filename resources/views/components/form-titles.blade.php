@props([
    'editMode' => false,
    'label' => ''
])

<div class="card-header bg-rosa text-white mt-3 mb-3">
    <h5 class="mb-0 fw-semibold">
        {{ $editMode ? 'Editar ' . $label : 'Novo ' . $label }}
    </h5>
</div>
