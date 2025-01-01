@extends('panel.components.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">

      @if ($errors->any())
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach ($errors->all() as $error)
            {{$error}}
        @endforeach
      </div>
      @endif
      @if (session()->has('message'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{session()->get('message')}}
      </div>
      @endif

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Categories</h1>
          </div><!-- /.col -->
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div><!-- /.col --> 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="card">
          <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
              Create
            </button>

            <!-- create modal -->
            <div class="modal fade" id="modal-create">
              <div class="modal-dialog">
                <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Create Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name En</label>
                      <input type="text" class="form-control" name="name_en" placeholder="Name En">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name Ar</label>
                      <input type="text" class="form-control" name="name_ar" placeholder="Name Ar">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Image</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose Image</label>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </form>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="data-table" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Name En</th>
                <th>Name Ar</th>
                <th>Image</th>
                <th>Show</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($categories as $category)
                <tr>
                <td>{{$category->name_en}}</td>
                <td>{{$category->name_ar}}</td>
                <td>@if ($category->image)<img src="{{url($category->image)}}" class="img-circle" width="50px" height="50px">@endif</td>
                <td>
                  <form action="{{route('admin.categories.active',$category->id)}}" method="POST">
                    @csrf
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="active" class="custom-control-input" id="customSwitch{{$category->id}}" @if($category->active) checked @endif>
                      <label class="custom-control-label" for="customSwitch{{$category->id}}"></label>
                    </div>
                  </form>
                </td>
                <td>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{$category->id}}">
                    Edit
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-edit{{$category->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('admin.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Name En</label>
                            <input type="text" class="form-control" value="{{$category->name_en}}" name="name_en" placeholder="Name En">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Name Ar</label>
                            <input type="text" class="form-control" value="{{$category->name_ar}}" name="name_ar" placeholder="Name Ar">
                          </div>
      
                          <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">{{$category->image}}</label>
                              </div>
                            </div>
                          </div>
      
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                    </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$category->id}}">
                    Delete
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-delete{{$category->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('admin.categories.delete',$category->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <label for="exampleInputEmail1">Do you want to delete?</label>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger">Confirm</button>
                        </div>
                      </div>
                    </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                </td>
              </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


@section('scripts')
  
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
  $(function () {

    $('#data-table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $('.custom-control-input').change(function() {
      $(this).closest('form').submit();
    });

  });

  $(function () {
    bsCustomFileInput.init();
  });
</script>
@endsection