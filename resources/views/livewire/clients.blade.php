<div>
    <main class="app-main">

        
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cadastrar Clientes</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Página Inicial</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Formulário de clientes</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="card card-custom card-outline mb-4">
                        <!--begin::Header-->
                        <x-form-titles :edit-mode="$editMode" label="Cliente"/>
                        

                        <!--end::Header-->
                        <!--begin::Form-->
                        <form wire:submit.prevent="save">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="nome" wire:model="name" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" wire:model="email" />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        id="telefone"
                                        wire:model="phone"
                                        placeholder="exemplo 81995995959"
                                    />
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>


                            <x-form-buttons :edit-mode="$editMode" cancel-action="resetForm" />
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                
                            <!-- Header -->
                            <div class="card-header">
                                <h3 class="card-title mb-0">Clientes</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 130px;">
                                        <input wire:model.live="search" type="text" class="form-control float-right" placeholder="Buscar">
                                        <div class="input-group-append">
                                            <button class="btn btn-default"><i class="bi bi-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <!-- Tabela -->
                            <div class="card-body table-responsive p-0" style="overflow-x: auto;">
                                <table class="table table-hover mb-0" style="min-width: 600px; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clients as $client)
                                            <tr>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $client->id }})" class="btn btn-sm btn-primary">Editar</button>
                                                    <button wire:click="confirmDelete({{ $client->id }})" class="btn btn-sm btn-danger">Excluir</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Nenhum cliente encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                
                            <!-- Paginação Compacta -->
                            @if($clients->hasPages())
                            <div class="card-footer bg-white py-2 px-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-muted" style="font-size: .8rem;">
                                        Mostrando <strong>{{ $clients->firstItem() }}</strong> a
                                        <strong>{{ $clients->lastItem() }}</strong> de
                                        <strong>{{ $clients->total() }}</strong> resultados
                                    </small>
                
                                    <nav aria-label="Navegação de páginas">
                                        <ul class="pagination pagination-sm mb-0 flex-nowrap" style="overflow-x: auto; white-space: nowrap;">
                                            {{-- “Anterior” --}}
                                            @if ($clients->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                        Anterior
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <button wire:click="previousPage" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                        Anterior
                                                    </button>
                                                </li>
                                            @endif
                
                                            {{-- Apenas 3 botões em torno da página atual --}}
                                            @php
                                                $current = $clients->currentPage();
                                                $last    = $clients->lastPage();
                                                $start   = max(1, $current - 1);
                                                $end     = min($last,  $current + 1);
                                            @endphp
                
                                            @for ($page = $start; $page <= $end; $page++)
                                                @if ($page == $current)
                                                    <li class="page-item active">
                                                        <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                            {{ $page }}
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <button wire:click="gotoPage({{ $page }})" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                            {{ $page }}
                                                        </button>
                                                    </li>
                                                @endif
                                            @endfor
                
                                            {{-- “Próximo” --}}
                                            @if ($clients->hasMorePages())
                                                <li class="page-item">
                                                    <button wire:click="nextPage" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                        Próximo
                                                    </button>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">
                                                        Próximo
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            @endif
                
                        </div>
                    </div>
                </div>
                

                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>

    
</div>


