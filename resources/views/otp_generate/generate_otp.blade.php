<x-admin-layout>
    <style>
    body.vertical-layout.vertical-menu-modern.menu-expanded .footer {
        margin-left: 0px;
    }
    </style>
    
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Position</h3><br>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Positions</a>
                                </li>
                                <li class="breadcrumb-item active">View Position
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- <div class="content-header-right col-md-6 col-12">
                    <div class="dropdown float-md-right">
                        <button class="btn btn-danger  round btn-glow px-2">Actions</button>
    
                    </div>
                </div> -->
            </div>
    
            @if(session()->has('roleinster'))
            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{session('roleinster')}}
            </div>
            @endif
            <!-- Form wizard with icon tabs section start -->
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-tooltip">View Position</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show table-responsive">
                            <div class="card-body ">
    
                                <table class="table table-striped table-bordered dataex-html5-selectors table-responsive">
                                    <thead>
                                        <tr>
                                            <th>user id</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>OTP Password</th>
                                            <th>OTP Status</th>
                                            <th>Password Status</th>
                                            <th>generate new otp</button></th>
                                            <th>Password Change Date</th>
                                            <th>Expiry Time</th>
                                            
                                          </tr>
                                    </thead>
    
                                    <tbody>
                                       

                                        @foreach($userpost as $i)
    
                                        <tr>
                                             
                                            <td>{{$i['id']}}</td>
                                            <td>{{$i['name']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{$i['mobile']}}</td>
                                
                                            @if (!$i['temp_password'])
                                            <td>{{$i['password']}}</td>    
                                            @else 
                                                <td>{{$i['temp_password']}}</td>
                                            @endif
                                            
                                            @if ($i['temp_password'])
                                            <td>new otp sent</td>    
                                            @else 
                                                <td>Active</td>
                                            @endif
                                
                                            @if ($i['temp_password'])
                                            <td>Not Activated</td>    
                                            @else 
                                                <td>Activated</td>
                                            @endif
                                
                                             
                                            <td> <button><a href="{{ url('generate_new_otp/'. $i->id) }}"> generate new otp </a></button> </td>
                                
                                
                                
                                            <td>{{$i['updated_at']}}</td>
                                            @if(now()->diffInDays($i->otp_create_date) > 30)
                                            <td>Expired</td>
                                            @else
                                            <td>{{ now()->diffInDays($i->otp_create_date) }}</td>
                                            @endif
                                            

                                            
                                          </tr>
                                          @endforeach
                                       
    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>user id</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>OTP Password</th>
                                            <th>OTP Status</th>
                                            <th>Password Status</th>
                                            <th>generate new otp</button></th>
                                            <th>Password Change Date</th>
                                            <th>Expiry Time</th>
                                            
                                          </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form wizard with icon tabs section end -->
     
    
                                    </x-admin-layout>












