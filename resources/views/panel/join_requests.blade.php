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
            <h1 class="m-0">Join Requests</h1>
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
          <div class="card-header">

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="data-table" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Store Name</th>
                <th>City</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($joinRequests as $joinRequest)
                <tr>
                <td>{{$joinRequest->store_name}}</td>
                <td>{{$joinRequest->city->name_en}}</td>
                <td>{{$joinRequest->phone}}</td>
                <td>{{date('Y-m-d h:i:s A', strtotime($joinRequest->created_at))}}</td>
                <td>
                  <!-- /.modal -->
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$joinRequest->id}}">
                    Delete
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-delete{{$joinRequest->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('panel.join-requests.delete',$joinRequest->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Contact Us</h4>
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
  });

</script>
@endsection