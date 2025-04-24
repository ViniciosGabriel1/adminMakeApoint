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
                    <div class="card card-warning card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Formulário de Cadastro</div>
                        </div>
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ $editMode ? 'Atualizar' : 'Cadastrar' }}
                                </button>
                                @if ($editMode)
                                    <button type="button" wire:click="resetForm" class="btn btn-outline-danger">Cancelar</button>
                                @endif
                            </div>
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
                            <div class="card-header">
                                <h3 class="card-title">Seus Serviços Cadastrados</h3>

                                <!-- Campo de busca -->
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input wire:model.live="search" type="text" class="form-control float-right" placeholder="Buscar serviço">
                                        <div class="input-group-append">
                                            <button class="btn btn-default">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
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
                                                <td>{{ $service->description }}</td>
                                                <td>{{ $service->value}}</td>
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

                            <!-- Paginação -->
                            <div class="mt-4 m-5">
                                @if ($services->hasPages())
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="mb-2">
                                            <p class="mb-0 text-muted">
                                                Mostrando
                                                <strong>{{ $services->firstItem() }}</strong>
                                                a
                                                <strong>{{ $services->lastItem() }}</strong>
                                                de
                                                <strong>{{ $services->total() }}</strong>
                                                resultados
                                            </p>
                                        </div>

                                        <nav>
                                            <ul class="pagination mb-0">
                                                {{-- Anterior --}}
                                                @if ($services->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Anterior</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <button wire:click="previousPage"
                                                            class="page-link">Anterior</button>
                                                    </li>
                                                @endif

                                                {{-- Páginas --}}
                                                @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                                                    @if ($page == $services->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <button wire:click="gotoPage({{ $page }})"
                                                                class="page-link">
                                                                {{ $page }}
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Próximo --}}
                                                @if ($services->hasMorePages())
                                                    <li class="page-item">
                                                        <button wire:click="nextPage" class="page-link">Próximo</button>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Próximo</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                @endif
                            </div>
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
