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
                                        <form action="{{route('vendor.store')}}" method="post" enctype="multipart/form-data">
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
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                                                        @error('email')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input type="file" name="image" class="form-control" id="image">
                                                        @error('image')
                                                        <small id="imageHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
                                                        <input id="password" placeholder="Confirm Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
                                                        @error('password')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <select name="country" class="form-control" id="countries"></select>
                                                        @error('country')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <select name="city" class="form-control" id="cities"></select>
                                                        @error('city')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="is_featured" style="zoom: 2;">
                                                    <span class="mx-1 font-weight-bold" style="font-size: 20px"> Is Featured</span>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="active" style="zoom: 2;">
                                                    <span class="mx-1 font-weight-bold" style="font-size: 20px"> Active</span>
                                                </div>
                                                <div class="col-md-12 mt-2">
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
                                                    <th>Resubscribe</th>
                                                    <th>Status</th>
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
                                                        <td>
                                                            @if ($vendor->end_subscription < date('Y-m-d'))
                                                                <button class="btn btn-success resubscribe-vendor" data-id="{{$vendor->id}}">Resubscribe</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select name="status" id="changeStatusField" data-id="{{ $vendor->id }}" data-type="update-vendor-status" class="form-control">
                                                                @foreach ($statusList as $status)
                                                                    <option value="{{ $status }}" @if ($status == $vendor->status) selected @endif>{{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            @if(in_array(\App\Models\Vendor::ROLE_PREFIX . '.show', $userAuthPermission))
                                                            <a href="{{route('vendor.show' , $vendor->id )}}" class="btn btn-info">View</a>
                                                            @endif

                                                            @if(in_array(\App\Models\Vendor::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                            <a href="{{route('vendor.edit' , $vendor->id )}}" class="btn btn-primary">Edit</a>
                                                            @endif

                                                            @if(in_array(\App\Models\Vendor::ROLE_PREFIX . '.destroy', $userAuthPermission))
                                                            <form action="{{route('vendor.destroy', $vendor->id)}}" method="post">
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
                                            {!! $vendors->links() !!}
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
@section('script')
    <script>
        let country = "{!! $defaultCountry !!}";
        let cities = JSON.parse({!! $jordanian_cities !!});
        $(document).on('ready', function() {
            fitCountries();
            fitCitiesByCountry();
        });

        function fitCitiesByCountry() {
            $('#cities').empty();
            let currentCities = cities[country];
            let cityOptions = "";
            currentCities.forEach(function (city) {
                cityOptions += `<option value="${city.name}">${city.name}</option>`;
            });
            $('#cities').append(cityOptions);
        }

        function fitCountries() {
            let countryOptions = "";
            for (let country in cities) {
                countryOptions += `<option value="${country}">${country}</option>`;
            }
            $('#countries').append(countryOptions);
        }

        $('#countries').on('change', function () {
            country = $('#countries').val();
            fitCitiesByCountry();
        });
    </script>

@include ('backend.layouts.footer')
