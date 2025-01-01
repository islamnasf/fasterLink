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
                        <h1 class="m-0">NFC</h1>
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

                <form action="{{ route('admin.settings.update', 5) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <label>{{ $nfc[0]->name_en }}</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-check mr-2">
                                              <input class="form-check-input" type="radio" id="imageRadio" name="file_type" value="image" @if ($nfc[0]->file_type == 'image') checked @endif>
                                              <label class="form-check-label">Image</label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" id="videoRadio" name="file_type" value="video" @if ($nfc[0]->file_type == 'video') checked @endif>
                                              <label class="form-check-label">Video</label>
                                            </div>
                                          </div>
                                          <div class="input-group" id="fileInputGroup" style="display: none;">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">{{ $nfc[0]->image }}</label>
                                            </div>
                                        </div>
                                        <div id="textInputGroup" style="display: none;">
                                            <input type="text" class="form-control" value="{{$nfc[0]->file}}" name="file" placeholder="Video URL">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    {{-- <div class="form-group">
                                        <label>Description En</label>
                                          @if ($nfc[0]->file_type == 'image')
                                            @if ($nfc[0]->file) <img src="{{url($nfc[0]->file)}}" class="img-circle" width="50px" height="50px"> @else <div style="color: silver" width="50px" height="50px"></div> @endif
                                          @else 
                                            <div>asd</div>
                                          @endif
                                    </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description En</label>
                                        <textarea id="description_en0" name="description_en">{{ $nfc[0]->description_en }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description Ar</label>
                                        <textarea id="description_ar0" name="description_ar">{{ $nfc[0]->description_ar }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="number" class="form-control" name="price"
                                            value="{{ $nfc[0]->price }}" placeholder="Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>

                <form action="{{ route('admin.settings.update', 6) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <label>{{ $nfc[1]->name_en }}</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description En</label>
                                        <textarea id="description_en1" name="description_en">{{ $nfc[1]->description_en }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description Ar</label>
                                        <textarea id="description_ar1" name="description_ar">{{ $nfc[1]->description_ar }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="number" class="form-control" name="price"
                                            value="{{ $nfc[1]->price }}" placeholder="Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>

                <form action="{{ route('admin.settings.update', 7) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <label>{{ $nfc[2]->name_en }}</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description En</label>
                                        <textarea id="description_en2" name="description_en">{{ $nfc[2]->description_en }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Description Ar</label>
                                        <textarea id="description_ar2" name="description_ar">{{ $nfc[2]->description_ar }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="number" class="form-control" name="price"
                                            value="{{ $nfc[2]->price }}" placeholder="Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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
            $('#description_en0').summernote();
            $('#description_ar0').summernote();
            $('#description_en1').summernote();
            $('#description_ar1').summernote();
            $('#description_en2').summernote();
            $('#description_ar2').summernote();


            function toggleInputFields() {
                if ($('#imageRadio').is(':checked')) {
                    $('#fileInputGroup').show();
                    $('#textInputGroup').hide();
                } else if ($('#videoRadio').is(':checked')) {
                    $('#fileInputGroup').hide();
                    $('#textInputGroup').show();
                }
            }

            $('input[name="file_type"]').on('change', toggleInputFields);

        });
    </script>
@endsection
