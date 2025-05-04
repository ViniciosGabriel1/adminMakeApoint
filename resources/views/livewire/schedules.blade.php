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
                    <div class="card-custom border-rosa shadow-sm">
                        {{-- <div class="card-header bg-rosa text-white m-5">
                            <h5 class="card-title mb-0">
                                {{ $editMode ? 'Editar Agendamento' : 'Novo Agendamento' }}
                            </h5>
                        </div> --}}

                        <x-form-titles :edit-mode="$editMode" label="Agendamento" />

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
                                    @error('client_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- ...campos omitidos pra foco no estilo... --}}
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Data:</label>
                                        <input type="date" class="form-control" wire:model="data">
                                        @error('data')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Hora:</label>
                                        <input type="time" class="form-control" wire:model="hora">
                                        @error('hora')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Observações --}}
                                <div class="mb-4">
                                    <label class="form-label">Observações:</label>
                                    <textarea class="form-control" rows="3" wire:model="observacoes"
                                        placeholder="Digite qualquer observação relevante..."></textarea>
                                    @error('observacoes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
                                                        {{ $servico->title }} - R$
                                                        {{ number_format($servico->value, 2, ',', '.') }}
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

                                    <button wire:click.prevent="adicionarServico" class="btn btn-outline-rosa mt-2">
                                        + Adicionar Serviço
                                    </button>
                                </div>

                                {{-- Total --}}
                                <div class="bg-rosa-800 text-white p-3 rounded mb-4">
                                    <strong>TOTAL:</strong> R$ {{ number_format($total, 2, ',', '.') }}
                                </div>

                                <div class="mb-2">

                                    <x-form-buttons :edit-mode="$editMode" cancel-action="resetForm" />
                                </div>

                            </div>
                        </form>
                    </div>

                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">

                            <!-- Header -->
                            <div class="card-header">
                                <h3 class="card-title mb-0">Agendamentos</h3>

                                <!-- Campo de busca -->
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 120px;">
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

                            <!-- Corpo da Tabela (rolável) -->
                            <div class="card-body table-responsive p-0" style="overflow-x: auto;">
                                <table class="table table-hover mb-0" style="min-width: 800px; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Descrição</th>
                                            <th>Valor Total</th>
                                            <th>Status</th> {{-- NOVA COLUNA --}}
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($schedules as $schedule)
                                            <tr>
                                                <td>{{ $schedule->data }}</td>
                                                <td>{{ $schedule->hora }}</td>
                                                <td title="{{ $schedule->observacoes }}">
                                                    {{ Str::limit($schedule->observacoes, 50, '...') }}
                                                </td>
                                                <td>{{ number_format($schedule->valor_total, 2, '.', ',') }}</td>

                                                {{-- NOVO CAMPO STATUS COM ESTILIZAÇÃO --}}
                                                <td>
                                                    @php
                                                        $badgeClass = match ($schedule->status) {
                                                            'pending' => 'badge bg-warning text-dark',
                                                            'confirmed' => 'badge bg-success',
                                                            'cancelled' => 'badge bg-danger',
                                                            default => 'badge bg-secondary',
                                                        };
                                                    @endphp
                                                    <span class="{{ $badgeClass }}">
                                                        {{ ucfirst($schedule->status) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <button wire:click="confirmConclusion({{ $schedule->id }})"
                                                        class="btn btn-sm btn-success"
                                                        @if ($schedule->status === 'confirmed') disabled 
                                                        title="Agendamento já confirmado" @endif>
                                                        Concluir
                                                    </button>
                                                    <button wire:click="edit({{ $schedule->id }})"
                                                        class="btn btn-sm btn-primary">Editar</button>
                                                    <button wire:click="confirmDelete({{ $schedule->id }})"
                                                        class="btn btn-sm btn-danger">Excluir</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">Nenhum agendamento encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>


                            <!-- Paginação no card-footer -->
                            @if ($schedules->hasPages())
                                <div class="card-footer bg-white">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap py-2 px-3">
                                        <small class="text-muted" style="font-size: .8rem;">
                                            Mostrando <strong>{{ $schedules->firstItem() }}</strong> a
                                            <strong>{{ $schedules->lastItem() }}</strong> de
                                            <strong>{{ $schedules->total() }}</strong> resultados
                                        </small>

                                        <nav aria-label="Navegação de páginas">
                                            <ul class="pagination pagination-sm mb-0 flex-nowrap"
                                                style="overflow-x: auto; white-space: nowrap;">
                                                {{-- “Anterior” --}}
                                                @if ($schedules->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link"
                                                            style="font-size: .75rem; padding: .25rem .5rem;">Anterior</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <button wire:click="previousPage" class="page-link"
                                                            style="font-size: .75rem; padding: .25rem .5rem;">Anterior</button>
                                                    </li>
                                                @endif

                                                {{-- Apenas 3 botões em torno da página atual --}}
                                                @php
                                                    $current = $schedules->currentPage();
                                                    $last = $schedules->lastPage();
                                                    $start = max(1, $current - 1);
                                                    $end = min($last, $current + 1);
                                                @endphp

                                                @for ($page = $start; $page <= $end; $page++)
                                                    @if ($page == $current)
                                                        <li class="page-item active">
                                                            <span class="page-link"
                                                                style="font-size: .75rem; padding: .25rem .5rem;">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <button wire:click="gotoPage({{ $page }})"
                                                                class="page-link"
                                                                style="font-size: .75rem; padding: .25rem .5rem;">
                                                                {{ $page }}
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endfor

                                                {{-- “Próximo” --}}
                                                @if ($schedules->hasMorePages())
                                                    <li class="page-item">
                                                        <button wire:click="nextPage" class="page-link"
                                                            style="font-size: .75rem; padding: .25rem .5rem;">Próximo</button>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link"
                                                            style="font-size: .75rem; padding: .25rem .5rem;">Próximo</span>
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

            </div>
        </div>


        <!--end::App Content-->
    </main>

</div>
