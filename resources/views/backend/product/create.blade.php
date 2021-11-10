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
                                        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
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
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->title}}</option>
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
                                                        <input type="file" name="images[]" class="form-control" multiple id="images" placeholder="images">
                                                        @error('images')
                                                        <small id="imagesHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="barcode">Barcode</label>
                                                        <input type="text" name="barcode" class="form-control" id="barcode" placeholder="Barcode">
                                                        @error('barcode')
                                                        <small id="barcodeHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" class="form-control" id="description"></textarea>
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
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Old Price</th>
                                                    <th>Price</th>
                                                    <th>Vendor</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($products) > 0)
                                                    @foreach($products as $product)
                                                        <tr>
                                                            <td><img src="{{ asset('assets/images/uploads/products/'.$product->main_image)}}" class="rounded" width="75" height="75" alt=""></td>
                                                            <td>{{$product->name}}</td>
                                                            <td>{{$product->category->title}}</td>
                                                            <td>{{$product->old_price}}</td>
                                                            <td>{{$product->price}}</td>
                                                            <td>{{$product->vendor->name}}</td>
                                                            <td class="d-flex align-items-center justify-content-center">
                                                                @if(in_array(\App\Models\Product::ROLE_PREFIX . '.show', $userAuthPermission))
                                                                <a href="{{route('product.show' , $product->id )}}" class="btn btn-info">View</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Product::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                                <a href="{{route('product.edit' , $product->id )}}" class="btn btn-primary">Edit</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Product::ROLE_PREFIX . '.destroy', $userAuthPermission))
                                                                <form action="{{route('product.destroy', $product->id)}}" method="post">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Delete</button>
                                                                </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7">
                                                            <div class="alert alert-warning">
                                                                There is no products
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="container">
                                            {!! $products->links() !!}
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
