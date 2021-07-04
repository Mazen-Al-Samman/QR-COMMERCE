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
                                        <h5>Admin Control</h5>
                                        <hr>
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <form action="{{route('admin.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
                                                        @error('username')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                                                        @error('email')
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="phone" name="phone" class="form-control" id="phone" placeholder="Phone">
                                                        @error('phone')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Role</label>
                                                        <select name="role" class="form-control" id="">
                                                            <option value="">Select..</option>
                                                            <option value="1">1</option>
                                                        </select>
                                                        @error('phone')
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
                        <div class="row">
                            <div class="col-12">
                                @if(session()->has('delete'))
                                    <div class="alert alert-warning">
                                        {{ session()->get('delete') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Admin List</h5>
                                        <span class="d-block m-t-5">All Admins list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>phone</th>
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($admins as $admin)
                                                    <tr>
                                                        <td>{{$admin->username}}</td>
                                                        <td>{{$admin->email}}</td>
                                                        <td>{{$admin->phone}}</td>
                                                        <td>{{$admin->role->role_title}}</td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            <a href="{{route('admin.show' , $admin->id )}}" class="btn btn-info">View</a>
                                                            <a href="{{route('admin.edit' , $admin->id )}}" class="btn btn-primary">Edit</a>
                                                            <form action="{{route('admin.delete', $admin->id)}}" method="post">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
</div>
@include ('backend.layouts.footer')
