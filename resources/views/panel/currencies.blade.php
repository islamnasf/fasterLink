@extends('panel.components.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Currencies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Currencies</li>
                    </ol>
                </div><!-- /.col --> 
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                        Create Currency
                    </button>

                    <!-- Create Currency Modal -->
                    <div class="modal fade" id="modal-create">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.currencies.store') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Create Currency</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" placeholder="Country" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" class="form-control" name="code" placeholder="Code" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="symbol">Symbol</label>
                                            <input type="text" class="form-control" name="symbol" placeholder="Symbol" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal -->
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Symbol</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->country }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>
                                        <form action="{{ route('admin.currencies.active', $currency->id) }}" method="POST">
                                            @csrf
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="active" class="custom-control-input" id="customSwitch{{ $currency->id }}" @if($currency->is_active) checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{ $currency->id }}"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{ $currency->id }}">Edit</a>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="modal-edit{{ $currency->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.currencies.update', $currency->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Currency</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="country">Country</label>
                                                                <input type="text" class="form-control" name="country" value="{{ $currency->country }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="code">Code</label>
                                                                <input type="text" class="form-control" name="code" value="{{ $currency->code }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $currency->name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="symbol">Symbol</label>
                                                                <input type="text" class="form-control" name="symbol" value="{{ $currency->symbol }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal -->

                                        <form action="{{ route('admin.currencies.delete', $currency->id) }}" method="POST" class="d-inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
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
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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
