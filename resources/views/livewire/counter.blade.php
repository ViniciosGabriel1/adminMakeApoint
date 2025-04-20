<div class="bg-success p-5 text-center rounded shadow-sm">

    <div class="d-flex justify-content-center gap-3 mb-4">
        <button class="btn btn-success px-4" wire:click="increment">+</button>
        <button class="btn btn-danger px-4" wire:click="decrement">-</button>
    </div>

    <div class="bg-success-subtle d-inline-block rounded">
        <h1 class="display-4 text-success m-0 p-2">{{ $count }}</h1>
    </div>
    
</div>
