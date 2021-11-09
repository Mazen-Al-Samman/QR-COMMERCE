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
                                        <h5>Manage Permission</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Permission</h5>
                                        <hr>
                                        @if(session()->has('alert-update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('permission.update',['id' => $permission->id])}}" method="post">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Permission</label>
                                                        <input type="text" name="permission" class="form-control" id="permission" placeholder="Enter Permission" value="{{$permission->permission}}">
                                                        @error('permission')
                                                        <small id="permissionHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="description" id="description">{{$permission->description}}</textarea>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
