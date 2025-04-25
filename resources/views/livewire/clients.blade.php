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
                    <div class="card card-warning card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Horizontal Form</div>
                        </div>
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
                                        <input type="text" class="form-control" id="telefone" wire:model="phone" />
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
                                <h3 class="card-title">Clientes</h3>

                                <!-- Campo de busca -->
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input wire:model.live="search" type="text" class="form-control float-right"
                                            placeholder="Buscar">
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
                                            {{-- <th>ID</th> --}}
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clients as $client)
                                            <tr>
                                                {{-- <td>{{ $client->id }}</td> --}}
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $client->id }})"
                                                        class="btn btn-sm btn-primary">Editar</button>
                                                    <button wire:click="confirmDelete({{ $client->id }})"
                                                        class="btn btn-sm btn-danger">Excluir</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Nenhum cliente encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginação -->
                            {{-- <div class="card-footer d-flex justify-content-center">
                                <ul class="pagination">
                                    <!-- Link para a página anterior -->
                                    <li class="page-item {{ $clients->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $clients->previousPageUrl() }}">Anterior</a>
                                    </li>
                            
                                    <!-- Links das páginas -->
                                    @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $clients->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                            
                                    <!-- Link para a próxima página -->
                                    <li class="page-item {{ $clients->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $clients->nextPageUrl() }}">Próxima</a>
                                    </li>
                                </ul>
                            </div> --}}
                            <div class="mt-4 m-5">
                                @if ($clients->hasPages())
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="mb-2">
                                            <p class="mb-0 text-muted">
                                                Mostrando
                                                <strong>{{ $clients->firstItem() }}</strong>
                                                a
                                                <strong>{{ $clients->lastItem() }}</strong>
                                                de
                                                <strong>{{ $clients->total() }}</strong>
                                                resultados
                                            </p>
                                        </div>

                                        <nav>
                                            <ul class="pagination mb-0">
                                                {{-- Anterior --}}
                                                @if ($clients->onFirstPage())
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
                                                @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                                                    @if ($page == $clients->currentPage())
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
                                                @if ($clients->hasMorePages())
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
