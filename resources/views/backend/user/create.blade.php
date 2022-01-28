@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
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
                                        <h5>Manage User</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>User Control</h5>
                                        <hr>
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">First Name</label>
                                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter First Name">
                                                        @error('first_name')
                                                        <small id="firstNameHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">Last Name</label>
                                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Last Name">
                                                        @error('first_name')
                                                        <small id="lastNameHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Password</label>
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                                        @error('password')
                                                        <small id="passwordHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Confirm Password</label>
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
                                                        @error('password')
                                                        <small id="confirmPassword" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="phone" name="phone" class="form-control" id="phone" placeholder="Phone">
                                                        @error('phone')
                                                        <small id="phoneHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input type="file" name="image" class="form-control" id="image" placeholder="image">
                                                        @error('image')
                                                        <small id="imageHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Create</button>
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
                                        <h5>User List</h5>
                                        <span class="d-block m-t-5">All Users list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>phone</th>
                                                    <th>Verified</th>
                                                    <th>Status</th>
                                                    <th>Verify</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>{{$user->first_name}}</td>
                                                        <td>{{$user->last_name}}</td>
                                                        <td>{{$user->phone}}</td>
                                                        <td>@if($user->actived == 1) <span class="text-success">Verified</span> @else <span class="text-danger">Not Verified</span> @endif</td>
                                                        <td>
                                                            <select name="status" id="changeStatusField" data-id="{{ $user->id }}" data-type="update-user-status" class="form-control">
                                                                @foreach ($statusList as $status)
                                                                    <option value="{{ $status }}" @if ($status == $user->status) selected @endif>{{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="verify-user" data-id="{{ $user->id }}" data-type="verify-user" @if ($user->actived == 1) checked @endif name="actived" style="zoom: 2;">
                                                        </td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            @if(in_array(\App\Models\Admin::ROLE_PREFIX . '.show', $userAuthPermission))
                                                                <a href="{{route('user.show' , $user->id )}}" class="btn btn-info">View</a>
                                                            @endif

                                                            @if(in_array(\App\Models\Admin::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                                <a href="{{route('user.edit' , $user->id )}}" class="btn btn-primary">Edit</a>
                                                            @endif

                                                            @if(in_array(\App\Models\Admin::ROLE_PREFIX . '.destroy', $userAuthPermission))
                                                                <form action="{{route('user.destroy', $user->id)}}" method="post">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Delete</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="container">
                                            {!! $users->links() !!}
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
