<div>
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cadastrar Seus Serviços</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Página Inicial</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Formulário de Serviços</li>
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
                        {{-- <div class="card-header">
                            <div class="card-title">Formulário de Cadastro</div>
                        </div> --}}
                        <x-form-titles :edit-mode="$editMode" label="Serviço"/>

                        <!--end::Header-->
                        
                        <!--begin::Form-->
                        <form wire:submit.prevent="save">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="service_name" class="form-label">Nome do Serviço</label>
                                        <input type="text" class="form-control" id="service_name" wire:model="title" />
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="service_description" class="form-label">Descrição</label>
                                        <textarea class="form-control" id="service_description" wire:model="description"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="service_price" class="form-label">Preço</label>
                                        <input type="number" step="0.01" class="form-control" id="service_price" wire:model="value" />
                                        @error('value')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->

                            <!--begin::Footer-->
                            {{-- <div class="card-footer">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ $editMode ? 'Atualizar' : 'Cadastrar' }}
                                </button>
                                @if ($editMode)
                                    <button type="button" wire:click="resetForm" class="btn btn-outline-danger">Cancelar</button>
                                @endif
                            </div> --}}

                            <x-form-buttons :edit-mode="$editMode" cancel-action="resetForm" />

                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>

                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header d-flex justify-content-between align-items-center px-3">
                                <h3 class="card-title mb-0">
                                    Serviços Cadastrados
                                </h3>
                            
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 130px;">
                                        <input 
                                            wire:model.live="search" 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="Buscar serviço"
                                        >
                                        <button class="btn btn-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                
                            <!-- Tabela rolável -->
                            <div class="card-body table-responsive p-0" style="overflow-x: auto;">
                                <table class="table table-hover mb-0" style="min-width: 650px; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th>Nome do Serviço</th>
                                            <th>Descrição</th>
                                            <th>Preço</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($services as $service)
                                            <tr>
                                                <td>{{ $service->title }}</td>
                                                <td>{{ Str::limit($service->description, 50, '...') }}</td>
                                                <td>R$ {{ number_format($service->value, 2, ',', '.') }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $service->id }})" class="btn btn-sm btn-primary">Editar</button>
                                                    <button wire:click="confirmDelete({{ $service->id }})" class="btn btn-sm btn-danger">Excluir</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Nenhum serviço encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                
                            <!-- Paginação Compacta -->
                            @if($services->hasPages())
                            <div class="card-footer bg-white py-2 px-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-muted" style="font-size: .8rem;">
                                        Mostrando <strong>{{ $services->firstItem() }}</strong> a
                                        <strong>{{ $services->lastItem() }}</strong> de
                                        <strong>{{ $services->total() }}</strong> resultados
                                    </small>
                
                                    <nav aria-label="Navegação de páginas">
                                        <ul class="pagination pagination-sm mb-0 flex-nowrap" style="overflow-x: auto; white-space: nowrap;">
                                            {{-- “Anterior” --}}
                                            @if ($services->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">Anterior</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <button wire:click="previousPage" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">Anterior</button>
                                                </li>
                                            @endif
                
                                            {{-- Apenas 3 botões em torno da página atual --}}
                                            @php
                                                $current = $services->currentPage();
                                                $last    = $services->lastPage();
                                                $start   = max(1, $current - 1);
                                                $end     = min($last,  $current + 1);
                                            @endphp
                
                                            @for ($page = $start; $page <= $end; $page++)
                                                @if ($page == $current)
                                                    <li class="page-item active">
                                                        <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <button wire:click="gotoPage({{ $page }})" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">{{ $page }}</button>
                                                    </li>
                                                @endif
                                            @endfor
                
                                            {{-- “Próximo” --}}
                                            @if ($services->hasMorePages())
                                                <li class="page-item">
                                                    <button wire:click="nextPage" class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">Próximo</button>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="font-size: .75rem; padding: .25rem .5rem;">Próximo</span>
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
