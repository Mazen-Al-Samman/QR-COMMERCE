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
                                        <h5>Manage Categories</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Category</h5>
                                        <hr>
                                        @if(session()->has('alert-update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-update') }}
                                            </div>
                                        @endif
                                        <form action="{{route('category.update',['id' => $category->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" class="form-control" id="title" value="{{$category->title}}" placeholder="Enter Title">
                                                        @error('title')
                                                        <small id="titleHelp" class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="description">Vendor</label>
                                                        <select name="vendor" id="vendor" class="form-control">
                                                            @foreach($vendors as $vendor)
                                                                <option value="{{$vendor->id}}" {{$category->vendor_id == $vendor->id ? 'selected' : ''}}>{{$vendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('vendor')
                                                        <small id="vendorHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
