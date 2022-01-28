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
                                        <h5>Manage Banners</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Banner Control</h5>
                                        <hr>
                                        @if ($message = \Illuminate\Support\Facades\Session::get('alert-success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <form action="{{route('banner.update',['id' => $banner->id])}}" method="post" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" class="form-control" id="title"
                                                               placeholder="Enter Title" value="{{ $banner->title }}">
                                                        @error('title')
                                                        <small id="titleHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input type="file" name="image" class="form-control" id="image">
                                                        @error('image')
                                                        <small id="imageHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Vendor</label>
                                                        <select name="vendor_id" id="vendor_id" class="form-control">
                                                            @foreach($vendors as $vendor)
                                                                <option value="{{$vendor->id}}" @if ($vendor->id == $banner->vendor_id) selected @endif>{{$vendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('vendor_id')
                                                        <small id="imageHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Body</label>
                                                        <textarea class="form-control" id="body" name="body" placeholder="Enter Body">{{$banner->body}}</textarea>
                                                        @error('body')
                                                        <small id="titleHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="is_published" @if ($banner->is_published)
                                                        checked
                                                    @endif style="zoom: 2;">
                                                    <span class="mx-1 font-weight-bold" style="font-size: 20px"> Is Published</span>
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
@include ('backend.layouts.footer')
