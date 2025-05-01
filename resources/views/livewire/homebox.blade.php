<div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-rosa text-white p-3 rounded">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3>{{ $servicos }}</h3>
            <p class="mb-0">Serviços Cadastrados</p>
          </div>
          <i class="bi bi-gear-fill fs-1 text-white"></i> <!-- Ícone de serviços -->
        </div>
        <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
          Mais informações <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
      </div>
    </div>
  
    <div class="col-lg-3 col-6">
        <div class="small-box bg-rosa-600 text-white p-3 rounded">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              {{-- <h3>R$ {{ number_format($valorTotal, 2, ',', '.') }}</h3> --}}
              <h3>R$ 1000</h3>
              <p class="mb-0">Valor Total</p>
            </div>
            <i class="bi bi-cash-coin fs-1 text-white"></i> <!-- Ícone de valor total -->
          </div>
          <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
            Mais informações <i class="bi bi-arrow-right-circle-fill"></i>
          </a>
        </div>
    </div>
      
    <div class="col-lg-3 col-6">
      <div class="small-box bg-rosa-dark text-white p-3 rounded">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3>{{ $clientes }}</h3>
            <p class="mb-0">Clientes Cadastrados</p>
          </div>
          <i class="bi bi-person-fill-add fs-1 text-white"></i> <!-- Ícone de clientes -->
        </div>
        <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
          Mais informações <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
      </div>
    </div>
  
    <div class="col-lg-3 col-6">
      <div class="small-box bg-rosa-800 text-white p-3 rounded">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3>{{ $schedules }}</h3>
            <p class="mb-0">Total de Agendamentos</p>
          </div>
          <i class="bi bi-calendar-check-fill fs-1 text-white"></i> <!-- Ícone de agendamentos -->
        </div>
        <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
          Mais informações <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
      </div>
    </div>
</div>
