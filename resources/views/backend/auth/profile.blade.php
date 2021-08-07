@include ('backend.layouts.header')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ form-element ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Profile</h5>
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
                                                    <h5 class="mt-4"><i class="fas fa-user-lock bg-primary text-light p-3 rounded-circle"></i> <span class="ml-1 text-primary font-weight-bold">{{\Illuminate\Support\Facades\Auth::user()->role->role_title}}</span></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" name="username" class="form-control"
                                                               id="username" placeholder="Enter Username" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">
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
                                                               placeholder="Enter email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
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
                                                               placeholder="Phone" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
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
@include ('backend.layouts.footer')
