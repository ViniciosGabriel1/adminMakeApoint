<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                @hasSection('page-title')
                    
                <h3 class="mb-0">@yield('page-title')</h3>
                @endif
            </div>
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div> --}}
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>