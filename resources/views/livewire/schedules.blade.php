<div class="space-y-4">

    {{-- Selecionar cliente --}}


    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Agende suas Makes</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Página Inicial</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Formulário de Agendamentos</li>
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
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="card border-rosa shadow-sm mb-4">
                        <div class="card-header bg-rosa text-white">
                            <h5 class="card-title mb-0">
                                {{ $editMode ? 'Editar Agendamento' : 'Novo Agendamento' }}
                            </h5>
                        </div>
                    
                        <form wire:submit.prevent="salvar">
                            <div class="card-body">

                                   {{-- Seleção de cliente --}}
                        <div class="mb-4">
                            <label class="form-label">Cliente</label>
                            <select wire:model="client_id" class="form-select">
                                <option value="">Selecione um cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                                {{-- ...campos omitidos pra foco no estilo... --}}
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Data:</label>
                                        <input type="date" class="form-control" wire:model="data">
                                        @error('data') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                
                                    <div class="col-md-3">
                                        <label class="form-label">Hora:</label>
                                        <input type="time" class="form-control" wire:model="hora">
                                        @error('hora') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                {{-- Observações --}}
                                <div class="mb-4">
                                    <label class="form-label">Observações:</label>
                                    <textarea class="form-control" rows="3" wire:model="observacoes" placeholder="Digite qualquer observação relevante..."></textarea>
                                    @error('observacoes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                {{-- Serviços dinâmicos --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold mb-2 d-block">Serviços:</label>
                                    @foreach ($servicosSelecionados as $index => $servicoId)
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <select wire:model="servicosSelecionados.{{ $index }}"
                                                    wire:change="atualizarValor({{ $index }})"
                                                    class="form-select w-50">
                                                <option value="">Selecione um serviço</option>
                                                @foreach ($servicos as $servico)
                                                    <option value="{{ $servico->id }}">
                                                        {{ $servico->title }} - R$ {{ number_format($servico->value, 2, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                    
                                            <span class="fw-bold text-rosa-800">
                                                R$ {{ number_format($valores[$index] ?? 0, 2, ',', '.') }}
                                            </span>
                    
                                            <button wire:click.prevent="removerServico({{ $index }})"
                                                    class="btn btn-sm btn-danger">
                                                Remover
                                            </button>
                                        </div>
                                    @endforeach
                    
                                    <button wire:click.prevent="adicionarServico"
                                            class="btn btn-outline-rosa mt-2">
                                        + Adicionar Serviço
                                    </button>
                                </div>
                    
                                {{-- Total --}}
                                <div class="bg-rosa-800 text-white p-3 rounded mb-4">
                                    <strong>TOTAL:</strong> R$ {{ number_format($total, 2, ',', '.') }}
                                </div>
                    
                                {{-- Ações --}}
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-outline-rosa">
                                        {{ $editMode ? 'Atualizar' : 'Criar' }}
                                    </button>
                    
                                    @if ($editMode)
                                        <button type="button" wire:click="resetForm" class="btn btn-outline-secondary">
                                            Cancelar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
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
                                            <th>data</th>
                                            <th>hora</th>
                                            <th>descrição</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($schedules as $schedule)
                                            <tr>
                                                {{-- <td>{{ $schedule->id }}</td> --}}
                                                <td>{{ $schedule->data }}</td>
                                                <td>{{ $schedule->hora }}</td>
                                                <td>{{ $schedule->observacoes }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $schedule->id }})"
                                                        class="btn btn-sm btn-primary">Editar</button>
                                                    <button wire:click="confirmDelete({{ $schedule->id }})"
                                                        class="btn btn-sm btn-danger">Excluir</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Nenhum agendamento encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 m-5">
                                @if ($schedules->hasPages())
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="mb-2">
                                            <p class="mb-0 text-muted">
                                                Mostrando
                                                <strong>{{ $schedules->firstItem() }}</strong>
                                                a
                                                <strong>{{ $schedules->lastItem() }}</strong>
                                                de
                                                <strong>{{ $schedules->total() }}</strong>
                                                resultados
                                            </p>
                                        </div>

                                        <nav>
                                            <ul class="pagination mb-0">
                                                {{-- Anterior --}}
                                                @if ($schedules->onFirstPage())
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
                                                @foreach ($schedules->getUrlRange(1, $schedules->lastPage()) as $page => $url)
                                                    @if ($page == $schedules->currentPage())
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
                                                @if ($schedules->hasMorePages())
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
            </div>
        </div>
        
        
        <!--end::App Content-->
    </main>
   
</div>
