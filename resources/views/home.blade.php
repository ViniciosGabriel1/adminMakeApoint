@extends('layouts.default')
@section('page-title', 'DashZada')

@section('content')
    <div class="row">
        <!--begin::Col-->
        <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-rosa text-white p-3 rounded">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>150</h3>
                    <p class="mb-0">New Orders</p>
                  </div>
                  <i class="bi bi-cart-fill fs-1 text-white"></i>
                </div>
                <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
                  More info <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
              </div>
            </div>
          
            <div class="col-lg-3 col-6">
              <div class="small-box bg-rosa-600 text-white p-3 rounded">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>53<sup class="fs-6">%</sup></h3>
                    <p class="mb-0">Bounce Rate</p>
                  </div>
                  <i class="bi bi-bar-chart-fill fs-1 text-white"></i>
                </div>
                <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
                  More info <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
              </div>
            </div>
          
            <div class="col-lg-3 col-6">
              <div class="small-box bg-rosa-dark text-white p-3 rounded">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>44</h3>
                    <p class="mb-0">User Registrations</p>
                  </div>
                  <i class="bi bi-person-plus-fill fs-1 text-white"></i>
                </div>
                <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
                  More info <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
              </div>
            </div>
          
            <div class="col-lg-3 col-6">
              <div class="small-box bg-rosa-800 text-white p-3 rounded">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>65</h3>
                    <p class="mb-0">Unique Visitors</p>
                  </div>
                  <i class="bi bi-people-fill fs-1 text-white"></i>
                </div>
                <a href="#" class="small-box-footer text-white text-decoration-none d-block mt-2">
                  More info <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
              </div>
            </div>
          </div>
          
        <!--end::Col-->
    {{-- @livewire('counter') --}}
    @livewire('calendar')

    </div>

    {{-- <div class="row">
        <!-- Start col -->
        <div class="col-lg-7 connectedSortable">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Sales Value</h3>
                </div>
                <div class="card-body">
                    <div id="revenue-chart"></div>
                </div>
            </div>
            <!-- /.card -->
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Direct Chat</h3>
                    <div class="card-tools">
                        <span title="3 New Messages" class="badge text-bg-primary"> 3 </span>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
                            <i class="bi bi-chat-text-fill"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                        <!-- Message. Default to the start -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-start"> Alexander Pierce </span>
                                <span class="direct-chat-timestamp float-end"> 23 Jan 2:00 pm </span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="{{ Vite::asset('resources/images/user1-128x128.jpg') }}"
                                alt="message user image" />
                            {{-- <img src="{{ Vite::asset('resources/images/user1-128x128.jpg') }}"> 


                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                        <!-- Message to the end -->
                        <div class="direct-chat-msg end">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-end"> Sarah Bullock </span>
                                <span class="direct-chat-timestamp float-start"> 23 Jan 2:05 pm </span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            {{-- <img class="direct-chat-img" {{-- src="../../dist/assets/img/user3-128x128.jpg" 
                                src="{{ Vite::asset('resources/images/user3-128x128.jpg') }}" alt="message user image" />
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">You better believe it!</div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                        <!-- Message. Default to the start -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-start"> Alexander Pierce </span>
                                <span class="direct-chat-timestamp float-end"> 23 Jan 5:37 pm </span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            {{-- <img class="direct-chat-img" {{-- src="../../dist/assets/img/user1-128x128.jpg" 
                                src="{{ Vite::asset('resources/images/user1-128x128.jpg') }}" alt="message user image" />
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Working with AdminLTE on a great new app! Wanna join?
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                        <!-- Message to the end -->
                        <div class="direct-chat-msg end">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-end"> Sarah Bullock </span>
                                <span class="direct-chat-timestamp float-start"> 23 Jan 6:10 pm </span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            {{-- <img class="direct-chat-img" {{-- src="../../dist/assets/img/user3-128x128.jpg"
                                src="{{ Vite::asset('resources/images/user3-128x128.jpg') }}" alt="message user image" />
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">I would love to.</div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                    </div>
                    <!-- /.direct-chat-messages-->
                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user1-128x128.jpg"
                                        src="{{ Vite::asset('resources/images/user1-128x128.jpg') }}" alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date float-end"> 2/28/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> How have you been? I was...
                                        </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user7-128x128.jpg"
                                        alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Sarah Doe
                                            <small class="contacts-list-date float-end"> 2/23/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> I will be waiting for...
                                        </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user3-128x128.jpg"
                                        alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Nadia Jolie
                                            <small class="contacts-list-date float-end"> 2/20/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> I'll call you back at...
                                        </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user5-128x128.jpg"
                                        alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Nora S. Vans
                                            <small class="contacts-list-date float-end"> 2/10/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> Where is your new... </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user6-128x128.jpg"
                                        alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            John K.
                                            <small class="contacts-list-date float-end"> 1/27/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> Can I take a look at...
                                        </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="../../dist/assets/img/user8-128x128.jpg"
                                        alt="User Avatar" />
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Kenneth M.
                                            <small class="contacts-list-date float-end"> 1/4/2023
                                            </small>
                                        </span>
                                        <span class="contacts-list-msg"> Never mind I found... </span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                        </ul>
                        <!-- /.contacts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control" />
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.direct-chat -->
        </div>
        <!-- /.Start col -->
        <!-- Start col -->
        <div class="col-lg-5 connectedSortable">
            <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                <div class="card-header border-0">
                    <h3 class="card-title">Sales Value</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="world-map" style="height: 220px"></div>
                </div>
                <div class="card-footer border-0">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-4 text-center">
                            <div id="sparkline-1" class="text-dark"></div>
                            <div class="text-white">Visitors</div>
                        </div>
                        <div class="col-4 text-center">
                            <div id="sparkline-2" class="text-dark"></div>
                            <div class="text-white">Online</div>
                        </div>
                        <div class="col-4 text-center">
                            <div id="sparkline-3" class="text-dark"></div>
                            <div class="text-white">Sales</div>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
            </div>
        </div>
        <!-- /.Start col -->
     </div>
--}}

@endsection
