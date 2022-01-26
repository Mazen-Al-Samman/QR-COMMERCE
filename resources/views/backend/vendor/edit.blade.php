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
                                        <h5>Edit Vendor</h5>
                                        <hr>
                                        @if(session()->has('update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('vendor.update',['id' => $vendor->id])}}" method="post" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Vendor Name</label>
                                                        <input type="text" value="{{$vendor->name}}" name="name" class="form-control" id="name" placeholder="Enter the vendor name">
                                                        @error('name')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="phone" value="{{$vendor->phone}}" name="phone" class="form-control" id="phone" placeholder="Phone">
                                                        @error('phone')
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
                                                        <label for="image">Image</label>
                                                        <input type="file" name="image" class="form-control" id="image">
                                                        @error('image')
                                                        <small id="imageHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="is_published" style="zoom: 2;" @if($vendor->is_featured == 1) checked @endif><span class="mx-1 font-weight-bold" style="font-size: 20px"> Is Featured</span>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="active" style="zoom: 2;"  @if($vendor->status == \App\Models\Vendor::STATUS_ACTIVE) checked @endif>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        let vendor = {!! $vendor !!};
        let vendor_country = vendor['country'];
        let vendor_city = vendor['city'];
        let default_country = "{!! $defaultCountry !!}";
        let cities = JSON.parse({!! $jordanian_cities !!});
        $(document).on('ready', function() {
            fitCountries();
            fitCitiesByCountry();
        });

        function fitCitiesByCountry() {
            $('#cities').empty();
            let currentCities = cities[default_country];
            let cityOptions = "";
            currentCities.forEach(function (city) {
                if (city.name == vendor_city) {
                    cityOptions += `<option selected value="${city.name}">${city.name}</option>`;
                } else {
                    cityOptions += `<option value="${city.name}">${city.name}</option>`;
                }
            });
            $('#cities').append(cityOptions);
        }

        function fitCountries() {
            let countryOptions = "";
            for (let country in cities) {
                if (country == default_country) {
                    countryOptions += `<option selected value="${country}">${country}</option>`;
                } else {
                    countryOptions += `<option value="${country}">${country}</option>`;
                }
            }
            $('#countries').append(countryOptions);
        }

        $('#countries').on('change', function () {
            default_country = $('#countries').val();
            fitCitiesByCountry();
        });
    </script>

@include ('backend.layouts.footer')
