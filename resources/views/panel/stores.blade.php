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
            <h1 class="m-0">Stores</h1>
          </div><!-- /.col -->
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col --> --}}
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="card">
 
          <div class="card-body">

            <div class="mb-2">
              <label for="mySelect">Status:</label>
              <select class="form-control" id="status" name="status" onchange="filter(this)">
              <option value="{{null}}">All</option>
              <option value="active" {{request('status')=='active'? 'selected' : ''}}>Active</option>
              <option value="inactive" {{request('status')=='inactive'? 'selected' : ''}}>Inactive</option>
              </select>
              </div>

            <table id="data-table" class="table table-bordered table-hover">
             
              <thead>
              <tr>
                <th>Brand Name</th>
                <th>Owner</th>
                <th>Logo</th>
                <th>Category</th>
                <th>Rating</th>
                <th>Points Type</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($stores as $store)
                <tr>
                <!-- <td>{{$store->name_en}}-{{$store->name_ar}}</td> -->
                <td>{{$store->name_en}}</td>
                <td>{{$store->user->name}}</td>
                <td>@if ($store->logo)<img src="{{url($store->logo)}}" class="img-circle" width="50px" height="50px">@endif</td>
                <td>{{$store->category->name_en}}</td>
                <td>{{round($store->ratings_avg_rating, 2)}}</td>
                <td>
                  @if ($store->cashback_enabled)
                  Cashback
                  @elseif ($store->loyalty_enabled)
                  Loyalty
                  @else
                  Disabled
                  @endif
                </td>
                <td>
                  <form action="{{route('admin.stores.status',$store->id)}}" method="POST">
                    @csrf
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="active" class="custom-control-input" id="customSwitch{{$store->id}}" @if($store->active) checked @endif>
                      <label class="custom-control-label" for="customSwitch{{$store->id}}"></label>
                    </div>
                  </form>
                </td>
                <td>
                  {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{$store->id}}">
                    Edit
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-edit{{$store->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('admin.stores.update',$store->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Store</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" value="{{$store->name}}" name="name" placeholder="Name">
                          </div>
      
                          <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">{{$store->image}}</label>
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
                  </div> --}}
                  <!-- /.modal -->
               
                  <a href="{{route('admin.stores.branches',$store->id)}}" class="btn btn-success">Branches</a>
                  <a href="{{route('admin.stores.departments',$store->id)}}" class="btn btn-secondary">Departments</a>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$store->id}}">
                    Delete
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-delete{{$store->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('admin.stores.delete',$store->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Store</h4>
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
                  <!-- <a href="{{route('admin.stores.details',$store->id)}}" class="btn btn-primary">Details</a> -->
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
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $('.custom-control-input').change(function() {
      $(this).closest('form').submit();
    });

  });

  function filter(status) {
    var selectedStatus = $('option:selected', status).val();
    let url = new URL(window.location.href);
    if (selectedStatus == "") {
      url.searchParams.delete('status');
    }else{
      url.searchParams.set('status',selectedStatus);
    }
    window.location.href = url
  }

</script>
@endsection