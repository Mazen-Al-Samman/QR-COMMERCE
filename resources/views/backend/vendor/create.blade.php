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
                                        <h5>Manage Vendor</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Vendors Control</h5>
                                        <hr>
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <form action="{{route('vendor.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Vendor Name</label>
                                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter the vendor name">
                                                        @error('name')
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
                                                        <label for="country">Country</label>
                                                        <select name="country" class="form-control" id="">
                                                            <option value="jordan">Jordan</option>
                                                        </select>
                                                        @error('country')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <select name="city" class="form-control" id="">
                                                            @foreach($jordanian_cities as $city)
                                                                <option value="{{$city['name']}}">{{$city['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('city')
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
                                        <h5>Vendors List</h5>
                                        <span class="d-block m-t-5">All Vendor list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Country</th>
                                                    <th>City</th>
                                                    <th>End of subscription</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($vendors as $vendor)
                                                    <tr>
                                                        <td>{{$vendor->name}}</td>
                                                        <td>{{$vendor->phone}}</td>
                                                        <td>{{$vendor->country}}</td>
                                                        <td>{{$vendor->city}}</td>
                                                        <td>{{$vendor->end_subscription}}</td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            <a href="{{route('vendor.show' , $vendor->id )}}" class="btn btn-info">View</a>
                                                            <a href="{{route('vendor.edit' , $vendor->id )}}" class="btn btn-primary">Edit</a>
                                                            <form action="{{route('vendor.delete', $vendor->id)}}" method="post">
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
