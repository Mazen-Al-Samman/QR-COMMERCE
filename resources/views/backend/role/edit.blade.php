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
                                        <h5>Manage Role</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Role</h5>
                                        <hr>
                                        @if(session()->has('alert-update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('role.update',['id' => $role->id])}}" method="post">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="role_title" class="form-control" id="title" placeholder="Enter Title" value="{{$role->role_title}}">
                                                        @error('role_title')
                                                        <small id="titleHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="role_description" id="description">{{$role->role_description}}</textarea>
                                                        @error('role_description')
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
