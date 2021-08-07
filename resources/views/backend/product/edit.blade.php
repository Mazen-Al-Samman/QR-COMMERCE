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
                                        <h5>Manage Products</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Product</h5>
                                        <hr>
                                        @if(session()->has('alert-update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-update') }}
                                            </div>
                                        @endif
                                        @if(session()->has('alert-delete'))
                                            <div class="alert alert-warning">
                                                {{ session()->get('alert-delete') }}
                                            </div>
                                        @endif
                                        <form action="{{route('product.update',['id' => $product->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" class="form-control" id="name" value="{{$product->name}}" placeholder="Enter name">
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
                                                                <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
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
                                                        <input type="text" name="old_price" class="form-control" id="old_price" value="{{$product->old_price}}" placeholder="Old Price">
                                                        @error('old_price')
                                                        <small id="old_priceHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" class="form-control" id="price" value="{{$product->price}}" placeholder="Price">
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
                                                        <input type="text" name="barcode" class="form-control" id="barcode" value="{{$product->barcode}}" placeholder="Barcode">
                                                        @error('barcode')
                                                        <small id="barcodeHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" class="form-control" id="description">{{$product->description}}</textarea>
                                                        @error('description')
                                                        <small id="descriptionHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 border-bottom">
                                                    <h5>Main Image</h5>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <img src="{{asset('assets/images/uploads/products/'.$product->main_image)}}" style="width: 100%; height: auto;"  class="rounded" alt="">
                                                </div>
                                                <div class="col-12 mt-4 mb-2 border-bottom">
                                                    <h5>Other Images</h5>
                                                </div>
                                                @foreach($images as $image)
                                                    <div class="col-auto">
                                                        <a href="{{ route('product_image.destroy',['id' => $image->id]) }}" class="bg-danger text-light rounded p-2" onclick="return confirm('Are you sure ?')" style="position: absolute; right: 20px; top: 5px;"><i class="fa fa-trash fa-lg"></i></a>
                                                        <img src="{{ asset('assets/images/uploads/products/'.$image->image)}}" style="width: 175px; height: 175px" class="rounded shadow" alt="">
                                                    </div>
                                                @endforeach
                                                <div class="col-md-12 mt-3">
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
