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
            <h1 class="m-0">Packages</h1>
          </div><!-- /.col -->
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Packages</li>
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
          <div class="card-body">
          <table id="data-table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Name En</th>
            <th>Name Ar</th>
            <th>Basic Price (All Currencies)</th>
            <th>Multi Branches Price (All Currencies)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
        <tr>
            <td>{{ $package->name_en }}</td>
            <td>{{ $package->name_ar }}</td>
            <td>
                @foreach ($package->packageCurrencies as $packageCurrency)
                    <p>{{ $packageCurrency->currency->name }}: {{ $packageCurrency->basic_price }}</p>
                @endforeach
            </td>
            <td>
                @foreach ($package->packageCurrencies as $packageCurrency)
                    <p>{{ $packageCurrency->currency->name }}: {{ $packageCurrency->multi_branches_price }}</p>
                @endforeach
            </td>
            <td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit{{ $package->id }}">
                    Edit
                </button>
 
                <!-- edit modal -->
                <div class="modal fade" id="modal-edit{{ $package->id }}">
    <div class="modal-dialog">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Package </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($activeCurrencies as $currency)
                        @php
                            // التحقق إذا كانت العملة موجودة في packageCurrencies
                            $packageCurrency = $package->packageCurrencies->where('currency_id', $currency->id)->first();
                        @endphp

                        <div class="form-group">
                            <label for="basic_price_{{ $currency->id }}">
                                Basic Price ({{ $currency->name }})
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                name="basic_price[{{ $currency->id }}]"
                                value="{{ $packageCurrency ? $packageCurrency->basic_price : '' }}"
                                placeholder="Basic Price"
                            >
                        </div>
                        <div class="form-group">
                            <label for="multi_branches_price_{{ $currency->id }}">
                                Multi Branches Price ({{ $currency->name }})
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                name="multi_branches_price[{{ $currency->id }}]"
                                value="{{ $packageCurrency ? $packageCurrency->multi_branches_price : '' }}"
                                placeholder="Multi Branches Price"
                            >
                        </div>
                    @endforeach
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


                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-elements-{{ $package->id }}">
    Link Elements
</button>

<!-- Modal to link elements -->
<div class="modal fade" id="modal-elements-{{ $package->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.packages.linkElements', $package->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Link Elements to Package</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Element Name</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($elements as $element)
                                <tr>
                                    <td>{{ $element->name_ar }}</td>
                                    <td>
                                        <input type="checkbox" name="elements[]" value="{{ $element->id }}" 
                                            {{ $package->elements->contains($element->id) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Elements</button>
                </div>
            </form>
        </div>
    </div>
</div>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

          </div>
        </div>
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
