@props([
    'editMode' => false,
    'submitLabel' => null,
    'cancelAction' => null,
])

<div class="card-footer">
    <!-- Botão de Ação -->
    <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled">
        {{ $submitLabel ?? ($editMode ? 'Atualizar' : 'Criar') }}
    </button>



    @if ($editMode && $cancelAction)
        <button type="button" wire:click="{{ $cancelAction }}" class="btn btn-outline-danger">
            Cancelar
        </button>
    @endif
    <!-- Estado de Carregamento -->
    <div wire:loading>
        <span class="spinner-border spinner-xs text-primary" role="status" aria-hidden="true"></span> <span
            class ="text-rosa">Carregando...</span>
    </div>
</div>
