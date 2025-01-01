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
            <h1 class="m-0">FAQ</h1>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
              Create
            </button>

            <!-- create modal -->
            <div class="modal fade" id="modal-create">
              <div class="modal-dialog">
                <form action="{{route('panel.faqs.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Create FAQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="app" value="{{request()->query('app')}}">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Question En</label>
                      <input type="text" class="form-control" name="question_en" placeholder="Question En">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Answer En</label>
                      <textarea class="form-control" name="answer_en" rows="6"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Question Ar</label>
                      <input type="text" class="form-control" name="question_ar" placeholder="Question Ar">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Answer Ar</label>
                      <textarea class="form-control" name="answer_ar" rows="6"></textarea>
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
                <th>Question En</th>
                <th>Question Ar</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($faqs as $faq)
                <tr>
                <td>{{$faq->question_en}}</td>
                <td>{{$faq->question_ar}}</td>
                <td>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{$faq->id}}">
                    Edit
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-edit{{$faq->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('panel.faqs.update',$faq->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit FAQ</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="app" value="{{request()->query('app')}}">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Question En</label>
                            <input type="text" class="form-control" name="question_en" value="{{$faq->question_en}}" placeholder="Question En">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Answer En</label>
                            <textarea class="form-control" name="answer_en" rows="6">{{$faq->answer_en}}</textarea>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Question Ar</label>
                            <input type="text" class="form-control" name="question_ar" value="{{$faq->question_ar}}" placeholder="Question Ar">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Answer Ar</label>
                            <textarea class="form-control" name="answer_ar" rows="6">{{$faq->answer_ar}}</textarea>
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
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete{{$faq->id}}">
                    Delete
                  </button>
                  <!-- edit modal -->
                  <div class="modal fade" id="modal-delete{{$faq->id}}">
                    <div class="modal-dialog">
                      <form action="{{route('panel.faqs.delete',$faq->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete FAQ</h4>
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