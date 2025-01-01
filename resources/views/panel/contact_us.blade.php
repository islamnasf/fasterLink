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
            <h1 class="m-0">Contact Us</h1>
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
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
              Create
            </button> --}}

            <!-- create modal -->
            {{-- <div class="modal fade" id="modal-create">
              <div class="modal-dialog">
                <form action="{{route('panel.contact-us.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Create Contact Us</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="app" value="{{request()->query('app')}}">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Question</label>
                      <input type="text" class="form-control" name="question" placeholder="Question">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Answer</label>
                      <textarea class="form-control" name="answer" rows="6"></textarea>
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
                <th>Phone</th>
                <th>Title</th>
                <th>App</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($ContactUs as $contact)
                <tr>
                <td>{{$contact->name}}</td>
                <td>{{$contact->phone}}</td>
                <td>{{$contact->title}}</td>
                <td>{{ucfirst($contact->app)}}</td>
                <td>{{date('Y-m-d h:i:s A', strtotime($contact->created_at))}}</td>
                <td>
                  {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{$contact->id}}">
                    Edit
                  </button> --}}
                  <!-- edit modal -->
                  {{-- <div class="modal fade" id="modal-edit{{$contact->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('panel.contact-us.update',$faq->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Contact Us</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="app" value="{{request()->query('app')}}">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Question</label>
                            <input type="text" class="form-control" name="question" value="{{$faq->question}}" placeholder="Question">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Answer</label>
                            <textarea class="form-control" name="answer" rows="6">{{$faq->answer}}</textarea>
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
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-details{{$contact->id}}">
                    Message
                  </button>
                  <!-- details modal -->
                  <div class="modal fade" id="modal-details{{$contact->id}}">
                    <div class="modal-dialog">
                   
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Contact Us Details</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea class="form-control" rows="10" readonly>{{$contact->message}}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$contact->id}}">
                    Delete
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-delete{{$contact->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('panel.contact-us.delete',$contact->id)}}" method="POST">
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