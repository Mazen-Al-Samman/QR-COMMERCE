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
                                        <form action="{{route('banner.store')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" class="form-control" id="title"
                                                               placeholder="Enter Title">
                                                        @error('title')
                                                        <small id="titleHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input type="file" name="image" class="form-control"
                                                               id="image">
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
                                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
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
                                                        <textarea class="form-control" id="body" name="body" placeholder="Enter Body"></textarea>
                                                        @error('body')
                                                        <small id="titleHelp"
                                                               class="form-text text-muted text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="is_published" style="zoom: 2;">
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
                        <div class="row">
                            <div class="col-12">
                                @if(session()->has('alert-delete'))
                                    <div class="alert alert-warning">
                                        {{ session()->get('alert-delete') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Banner List</h5>
                                        <span class="d-block m-t-5">All Banners list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Vendor</th>
                                                    <th>title</th>
                                                    <th>Body</th>
                                                    <th>Is Published</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($banners) > 0)
                                                    @foreach($banners as $banner)
                                                        <tr>
                                                            <td><img src="{{ asset('assets/images/uploads/banners/'.$banner->image)}}" class="rounded" width="75" height="75" alt=""></td>
                                                            <td>@if ($banner->vendor)
                                                                {{$banner->vendor->name}}
                                                            @else
                                                                <span class="font-weight-bold text-primary">My Bill</span>
                                                            @endif</td>
                                                            <td>{{$banner->title}}</td>
                                                            <td>{{$banner->body}}</td>
                                                            <td>
                                                                <input type="checkbox" class="published_status" data-id="{{ $banner->id }}" data-type="banner-published-status" @if ($banner->is_published == 1) checked @endif name="is_published" style="zoom: 2;">
                                                            </td>
                                                            <td class="d-flex align-items-center justify-content-center">
                                                                @if(in_array(\App\Models\Banner::ROLE_PREFIX . '.show', $userAuthPermission))
                                                                    <a href="{{route('banner.show' , $banner->id )}}"
                                                                       class="btn btn-info">View</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Banner::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                                    <a href="{{route('banner.edit' , $banner->id )}}"
                                                                       class="btn btn-primary">Edit</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Banner::ROLE_PREFIX . '.destroy', $userAuthPermission))
                                                                    <form
                                                                        action="{{route('banner.destroy', $banner->id)}}"
                                                                        method="post">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button class="btn btn-danger" type="submit"
                                                                                onclick="return confirm('Are You Sure?')">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7">
                                                            <div class="alert alert-warning">
                                                                There is no categories
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
                                            {!! $banners->links() !!}
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
