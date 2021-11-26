@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>User Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">First Name: </span>{{$user->first_name}}</li>
                                            <li><span class="font-weight-bold">Last Name: </span>{{$user->last_name}}</li>
                                            <li><span class="font-weight-bold">Phone: </span>{{$user->phone}}</li>
                                            <li><span class="font-weight-bold">Active: </span>@if ($user->actived == 1) Verified @else Not Verified @endif</li>
                                            @if ($user->image)
                                            <li>
                                                <span class="font-weight-bold">Image</span>
                                                <img src="{{ asset('assets/images/uploads/users/'.$user->image)}}" style="width: 100%; height: auto" class="rounded shadow" alt="">
                                            </li>
                                            @endif
                                        </ul>
                                        <a href="{{route('user.create')}}" class="btn btn-secondary">Back</a>
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
