@extends('panel.components.main')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
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
                        <h1 class="m-0">Settings</h1>
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

                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Email</label>
                                        <input type="text" class="form-control" name="admin_email"
                                            value="{{ @$settings->firstWhere('key', 'admin_email')->value }}"
                                            placeholder="Admin Email">
                                    </div>
                                </div>
                                <div class="col-6">

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    {{-- <div class="card">
                        <div class="card-header">
                            <label for="exampleInputEmail1">Social Links</label>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Facebook</label>
                                        <input type="text" class="form-control" name="facebook"
                                            value="{{ @$settings->firstWhere('key', 'facebook')->value }}"
                                            placeholder="Facebook">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Twitter</label>
                                        <input type="text" class="form-control" name="twitter"
                                            value="{{ @$settings->firstWhere('key', 'twitter')->value }}"
                                            placeholder="Twitter">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Snapchat</label>
                                        <input type="text" class="form-control" name="snapchat"
                                            value="{{ @$settings->firstWhere('key', 'snapchat')->value }}"
                                            placeholder="Snapchat">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Instagram</label>
                                        <input type="text" class="form-control" name="instagram"
                                            value="{{ @$settings->firstWhere('key', 'instagram')->value }}"
                                            placeholder="Instagram">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div> --}}
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <label>Network</label>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description En</label>
                                        <textarea id="network_description_en" name="network_description_en">{{ @$settings->firstWhere('key', 'network_description_en')->value }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                   <div class="form-group">
                                        <label>Description Ar</label>
                                        <textarea id="network_description_ar" name="network_description_ar">{{ @$settings->firstWhere('key', 'network_description_ar')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="number" class="form-control" name="network_price"
                                            value="{{ @$settings->firstWhere('key', 'network_price')->value }}"
                                            placeholder="Price">
                                    </div>
                                </div>
                            </div>
                   

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </form>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function() {
            $('#network_description_en').summernote();
            $('#network_description_ar').summernote();
        });
    </script>
@endsection
