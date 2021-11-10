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
                                        <h5>Manage Categories</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Category Control</h5>
                                        <hr>
                                        @if ($message = \Illuminate\Support\Facades\Session::get('alert-success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                                                        @error('title')
                                                        <small id="titleHelp" class="form-text text-muted text-danger">{{$message}}</small>
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
                                        <h5>Categories List</h5>
                                        <span class="d-block m-t-5">All Categories list information</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>title</th>
                                                    <th>Vendor</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($categories) > 0)
                                                    @foreach($categories as $category)
                                                        <tr>
                                                            <td><img src="{{ asset('assets/images/uploads/categories/'.$category->image)}}" class="rounded" width="75" height="75" alt=""></td>
                                                            <td>{{$category->title}}</td>
                                                            <td>{{$category->vendor->name}}</td>
                                                            <td class="d-flex align-items-center justify-content-center">
                                                                @if(in_array(\App\Models\Category::ROLE_PREFIX . '.show', $userAuthPermission))
                                                                <a href="{{route('category.show' , $category->id )}}" class="btn btn-info">View</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Category::ROLE_PREFIX . '.edit', $userAuthPermission))
                                                                <a href="{{route('category.edit' , $category->id )}}" class="btn btn-primary">Edit</a>
                                                                @endif

                                                                @if(in_array(\App\Models\Category::ROLE_PREFIX . '.destroy', $userAuthPermission))
                                                                <form action="{{route('category.destroy', $category->id)}}" method="post">
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
                                            {!! $categories->links() !!}
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
