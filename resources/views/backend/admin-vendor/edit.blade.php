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
                                        <h5>Manage Admin</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Admin</h5>
                                        <hr>
                                        @if(session()->has('update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('admin-vendor.update',['id' => $admin->id])}}" method="post">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">Admin Name</label>
                                                        <input type="text" name="username" class="form-control" id="username" value="{{$admin->name}}" placeholder="Enter the admin name">
                                                        @error('username')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="form-control" value="{{$admin->email}}" placeholder="Enter email">
                                                        @error('email')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="phone" name="phone" class="form-control" id="phone" value="{{$admin->phone}}" placeholder="Phone">
                                                        @error('phone')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Role</label>
                                                        <select name="role_id" class="form-control" id="">
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}" {{$admin->role_id == $role->id ? 'selected' : ''}}>{{$role->role_title}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('role_id')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Password</label>
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                                        @error('password')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Confirm Password</label>
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
                                                        @error('password')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
