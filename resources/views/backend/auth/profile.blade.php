@include ('backend.layouts.header')
<?php
$auth = auth()->user() ?? auth("vendor")->user();
?>
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    @if(session()->has('invalid-password'))
                        <div class="alert alert-danger">
                            {{ session()->get('invalid-password') }}
                        </div>
                    @endif
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ form-element ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h5>Profile</h5>
                                            </div>
                                            @if(auth("vendor")->user())
                                                <div class="col-12 col-md-6">
                                                    <span class="px-2">Access Key :</span>
                                                    <span class="px-2 text-danger">{{ $auth->vendor->access_key ?? "GENERATE ACCESS KEY" }}</span>
{{--                                                    <a href="{{route("admin-vendor.generate-access-key")}}" class="px-2"><i class="fa fa-refresh"></i></a>--}}
                                                    <span data-toggle="modal" data-target="#checkpassModal" class="px-2" style="cursor: pointer"><i class="fa fa-refresh"></i></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if(session()->has('update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('profile.update')}}" method="post">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="mt-4"><i class="fas fa-user-lock bg-primary text-light p-3 rounded-circle"></i> <span class="ml-1 text-primary font-weight-bold">{{$auth->role->role_title}}</span></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" name="username" class="form-control"
                                                               id="username" placeholder="Enter Username" value="{{$auth->username ?? $auth->name}}">
                                                        @error('username')
                                                        <small id="emailHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="form-control"
                                                               placeholder="Enter email" value="{{$auth->email}}">
                                                        @error('email')
                                                        <small id="emailHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="phone" name="phone" class="form-control" id="phone"
                                                               placeholder="Phone" value="{{$auth->phone}}">
                                                        @error('phone')
                                                        <small id="emailHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="checkpassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Access Key</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route("admin-vendor.generate-access-key")}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
