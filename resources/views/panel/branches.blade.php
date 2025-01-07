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
          <h1 class="m-0">Branchs</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.stores.index')}}">Stores</a></li>
            <li class="breadcrumb-item active">Branches</li>
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
          {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
              Create
            </button> --}}

          <!-- create modal -->
          {{-- <div class="modal fade" id="modal-create">
              <div class="modal-dialog">
                <form action="{{route('admin.stores.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create Branch</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name">
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
      </div> --}}
      <!-- /.modal -->

    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="data-table" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <!-- <th>Phone</th> -->
            <th>City</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($branches as $branch)
          <tr>
            <td>{{$branch->name_en}}</td>
            <!-- <td>{{$branch->phone}}</td> -->
            <td>{{$branch->city->name_en}}</td>
            <td>{{$branch->address_en}}</td>
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
                        <h4 class="modal-title">Edit Branch</h4>
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
              <a target="_blank" href="{{"https://www.google.com/maps?q=" . $branch->lat . "," . $branch->lng}}" class="btn btn-success">Location</a>

              <!-- Button to Open the Modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-numbers{{$branch->id}}">
                Show Numbers
              </button>

              <!-- Numbers Modal -->
              <div class="modal fade" id="modal-numbers{{$branch->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Branch Numbers</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <ul class="list-group">
                        @foreach($branch->numbers as $number)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span>
                            <div>Name : ({{ $number->name_ar }} / {{ $number->name_en }})</div>
                            {{ $number->type }} : {{ $number->number }}
                          </span>
                          <!-- Delete Button -->
                          <form action="{{ route('admin.branches.number.delete', $number->id) }}" method="POST" class="d-inline-block">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>



              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$branch->id}}">
                Delete
              </button>
              <!-- edit modal -->
              <div class="modal fade" id="modal-delete{{$branch->id}}">
                <div class="modal-dialog">
                  <form action="{{route('admin.branches.delete',$branch->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Delete Branch</h4>
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
  $(function() {

    $('#data-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(function() {
    bsCustomFileInput.init();
  });
</script>
@endsection