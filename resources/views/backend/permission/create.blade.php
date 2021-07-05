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
                                        <h5>Manage Permissions</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Permissions Control</h5>
                                        <hr>
                                        @if ($message = \Illuminate\Support\Facades\Session::get('alert-success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <form action="{{route('permission.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="permission">Permission</label>
                                                        <input type="text" name="permission" class="form-control" id="title" placeholder="Enter Permission">
                                                        @error('permission')
                                                        <small id="permissionHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <input type="text" name="description" class="form-control" id="description" placeholder="Enter Description">
                                                        @error('description')
                                                        <small id="descriptionHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
                                @if(session()->has('alert-delete'))
                                    <div class="alert alert-warning">
                                        {{ session()->get('alert-delete') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Permission List</h5>
                                        <span class="d-block m-t-5">All Permissions list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Permission</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($permissions as $permission)
                                                    <tr>
                                                        <td>{{$permission->permission}}</td>
                                                        <td>{{$permission->description}}</td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            <a href="{{route('permission.show' , $role->id )}}" class="btn btn-info">View</a>
                                                            <a href="{{route('permission.edit' , $role->id )}}" class="btn btn-primary">Edit</a>
                                                            <form action="{{route('permission.delete', $role->id)}}" method="post">
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
