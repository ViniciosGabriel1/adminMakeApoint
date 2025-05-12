<div class="min-vh-100 bg-rosa-50 p-4">
    <div class="container-lg">
        <!-- Header Section -->
        <header class="bg-rosa-light rounded-3 shadow-sm p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 text-rosa-dark mb-0 fw-bold">
                    <i class="bi bi-whatsapp me-2"></i> Conecte seu WhatsApp
                </h1>
                <p class="small text-muted mb-0">Gerencie sua conexão com o WhatsApp Web</p>
            </div>


            <div class="status-indicator">
                <!-- Estado de Carregamento -->
                <div wire:loading>
                    <span class="spinner-border spinner-xs text-primary" role="status" aria-hidden="true"></span> <span
                        class="text-rosa">Carregando...</span>
                </div>

                <!-- Estados Principais -->
                <div wire:loading.remove class="status-badge">
                    @if($status == 'connecting')
                    <div class="status-connecting">
                        <span class="spinner-border spinner-xs text-rosa me-2" role="status"></span>
                        <i class="bi bi-arrow-repeat me-2"></i>
                        <span>Conectando...</span>
                    </div>
                    @elseif($status == 'open')
                    <div class="status-connected">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Conectado</span>
                    </div>
                    @elseif($status == 'close')
                    <div class="status-disconnected">
                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                        <span>Desconectado</span>
                    </div>
                    @else
                    <div class="status-waiting">
                        <i class="bi bi-hourglass text-secondary me-2"></i>
                        <span>Aguardando</span>
                    </div>
                    @endif
                </div>
            </div>


        </header>

        <!-- Main Content -->
        <main class="row g-4">
            <!-- QR Code Section -->
            <section class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-rosa-light border-0 py-3">
                        <h2 class="h5 mb-0 text-rosa-dark fw-semibold">
                            <i class="bi bi-qr-code-scan me-2"></i>Conexão via QR Code
                        </h2>
                    </div>
                    <div class="card-body d-flex flex-column">
                        @if($qrCode)
                        <div class="text-center mb-4">
                            <img src="{{ $qrCode }}" alt="QR Code para conexão" class="img-fluid border p-2"
                                style="max-width: 300px;">

                            @if($status == 'open')
                            <div class="alert alert-success mt-3 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i> WhatsApp conectado com sucesso!
                            </div>
                            @else
                            <p class="text-muted small mt-2">Escaneie este código com o WhatsApp Web</p>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-qr-code fs-1 text-rosa mb-3"></i>
                            <p class="text-muted">Nenhum QR Code disponível no momento</p>

                            @if($status == 'open')
                            <div class="alert alert-success mt-3">
                                <i class="bi bi-check-circle-fill me-2"></i> WhatsApp já está conectado
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="mt-auto">
                            <div class="d-flex gap-2 flex-wrap">
                                @if($status != 'open')
                                <button class="btn btn-rosa flex-grow-1" wire:click="getQRCode">
                                    <i class="bi bi-arrow-repeat me-2"></i>Gerar QR Code
                                </button>
                                @else
                                <button class="btn btn-rosa flex-grow-1" disabled>
                                    <i class="bi bi-check-circle me-2"></i>Já conectado
                                </button>
                                @endif

                                {{-- <button class="btn btn-outline-rosa flex-grow-1">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Reiniciar
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Connection Info Section -->
            <section class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-rosa-light border-0 py-3">
                        <h2 class="h5 mb-0 text-rosa-dark fw-semibold">
                            <i class="bi bi-info-circle me-2"></i>Informações de Conexão
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-rosa-100 border-0 mb-4">
                            <h3 class="h6 fw-bold text-rosa-dark">Como conectar:</h3>
                            <ol class="small text-muted">
                                <li>Clique em "Gerar QR Code"</li>
                                <li>Abra o WhatsApp no seu celular</li>
                                <li>Toque nos <strong>três pontinhos</strong> no canto superior direito</li>
                                <li>Selecione <strong>Dispositivos conectados</strong></li>
                                <li>Toque em <strong>Conectar um dispositivo</strong></li>
                                <li>Aponte a câmera para o código QR na tela</li>
                            </ol>
                            <div class="mt-2 small text-rosa-800">
                                <i class="bi bi-info-circle me-1"></i> Certifique-se de que seu celular tenha conexão
                                com internet
                            </div>
                        </div>

                        <div class="connection-details">
                            <h3 class="h6 fw-bold text-rosa-dark mb-3">Status da Conexão</h3>
                            <ul class="list-group list-group-flush small">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                    <span>Última atualização:</span>
                                    <span class="fw-semibold">
                                        {{ $last_updated ? $last_updated->format('d/m/Y H:i:s') : 'Nunca atualizado' }}
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button class="btn btn-danger w-100" wire:click="disconnect">
                                <i class="bi bi-power me-2"></i>Desconectar
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<style>
    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .btn-rosa {
        background-color: var(--bs-rosa);
        color: white;
    }

    .btn-outline-rosa {
        border-color: var(--bs-rosa);
        color: var(--bs-rosa);
    }

    .btn-outline-rosa:hover {
        background-color: var(--bs-rosa);
        color: white;
    }

    .alert-rosa-100 {
        background-color: var(--bs-rosa-100);
    }

    .status-indicator .badge {
        min-width: 140px;
        justify-content: center;
    }

    </>