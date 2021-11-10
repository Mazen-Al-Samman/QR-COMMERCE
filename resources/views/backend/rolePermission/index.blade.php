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
                                        <h5>Manage Roles</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class=" table-responsive">
                                            <table class="table table-striped text-center">
                                                <tbody>
                                                <?php $i=0; ?>
                                                @foreach($roles as $role)
                                                    <tr>
                                                        <th>
                                                            {{$i}}
                                                        </th>
                                                        <th>
                                                        <span class="font-weight-bold" style="font-size: 20px">{{$role->role_title}}</span>
                                                        </th>
                                                        <td>
                                                            @if(in_array(\App\Models\RolePermission::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                            <a href="{{ route('role-permission.manage',['role_id'=> $role->id]) }}" class="btn btn-primary">Manage Permissions</a>
                                                            @endif

                                                            @if(in_array(\App\Models\RolePermission::ROLE_PREFIX . '.show', $userAuthPermission))
                                                            <a href="{{ route('role-permission.show',['role_id'=> $role->id]) }}" class="btn btn-info">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
