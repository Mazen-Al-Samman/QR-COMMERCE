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
                                        <h5>Add Permissions For "{{$role->role_title}}"</h5>
                                        @if(session()->has('alert-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-success') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('rolePermission.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$role->id}}" name="role_id">
                                            <div class="row">
                                                    @foreach($permissions as $permission)
                                                    <div class="col-auto m-1">
                                                        <input type="checkbox" value="{{$permission->id}}" name="permissions[]"> <span class="font-weight-bold ml-1" style="font-size: 18px">{{$permission->permission}}</span>
                                                    </div>
                                                    @endforeach
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary">Save</button>
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
