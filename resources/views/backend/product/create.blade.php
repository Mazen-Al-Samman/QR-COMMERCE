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
                                        <h5>Manage Product</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Product Control</h5>
                                        <hr>
                                        @if(session()->has('alert-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-success') }}
                                            </div>
                                        @endif
                                        <form action="{{route('product.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                                                        @error('name')
                                                        <small id="emailHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="category">Category</label>
                                                        <select name="category_id" id="category_id" class="form-control">
                                                            @foreach([1,2,3] as $item)
                                                                <option value="{{$item}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                        <small id="categoryHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="old_price">Old Price</label>
                                                        <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Old Price">
                                                        @error('old_price')
                                                        <small id="old_priceHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" class="form-control" id="price" placeholder="Price">
                                                        @error('price')
                                                        <small id="priceHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="main_image">Main Image</label>
                                                        <input type="file" name="main_image" class="form-control" id="main_image" placeholder="Main Image">
                                                        @error('main_image')
                                                        <small id="main_imageHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="images">Images</label>
                                                        <input type="file" name="images[]" class="form-control" id="images" placeholder="images">
                                                        @error('images')
                                                        <small id="imagesHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="vendor_id">Vendor</label>
                                                        <select name="vendor_id" id="vendor_id" class="form-control">
                                                            @foreach([1,2,3] as $item)
                                                                <option value="{{$item}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('vendor_id')
                                                        <small id="vendorHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Product List</h5>
                                        <span class="d-block m-t-5">All Products list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>phone</th>
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

{{--                                                @foreach($admins as $admin)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{$admin->username}}</td>--}}
{{--                                                        <td>{{$admin->email}}</td>--}}
{{--                                                        <td>{{$admin->phone}}</td>--}}
{{--                                                        <td>{{$admin->role->role_title}}</td>--}}
{{--                                                        <td class="d-flex align-items-center justify-content-center">--}}
{{--                                                            <a href="{{route('admin.show' , $admin->id )}}" class="btn btn-info">View</a>--}}
{{--                                                            <a href="{{route('admin.edit' , $admin->id )}}" class="btn btn-primary">Edit</a>--}}
{{--                                                            <form action="{{route('admin.delete', $admin->id)}}" method="post">--}}
{{--                                                                @method('delete')--}}
{{--                                                                @csrf--}}
{{--                                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Delete</button>--}}
{{--                                                            </form>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
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
