

<aside class="app-sidebar bg-custom-sidebar shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand show">
        <!--begin::Brand Link-->
        <a href="{{ url('/') }}" class="brand-link" aria-label="Página inicial">
            <!-- Logo da Marca -->
            <img 
                src="{{ Vite::asset('resources/images/Gleyce.png') }}" 
                alt="Logo da Make Appointment" 
                class="brand-image rounded-3"
                style="width: 50px; height: 50px;"
            >
        
            <!-- Nome da Marca -->
            <span class="brand-text fw-light">
                Gleyce MakeUp
            </span>
        </a>
        <!--end::Brand Link-->
    </div>
    
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                data-accordion="false">
                {{-- <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
              
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door"></i>
                        <p>Página Inicial</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('clients') }}" class="nav-link {{ request()->is('clientes') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('services') }}" class="nav-link {{ request()->is('servicos') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-brush"></i>
                        <p>Serviços</p>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a href="{{route('schedules')}}" class="nav-link {{ request()->is('agendamentos') ? 'active' : '' }}">
                        <i class="nav-icon 	bi bi-alarm"></i>
                        <p>Agendamentos</p>
                    </a>
                </li>

                <div style="position: absolute; bottom: 0; width: 80%; margin-bottom: 22px">
                    <ul class="nav sidebar-menu flex-column">
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" 
                                   class="nav-link "
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="nav-icon bi bi-box-arrow-right "></i>
                                    <p class="">Sair do Sistema</p>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                
               
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>