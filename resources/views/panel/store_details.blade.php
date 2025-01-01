@extends('panel.components.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
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
                    <p>{{ session()->get('message') }}</p>
                </div>
            @endif

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Store Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('panel.stores.index') }}">Stores</a></li>
                            <li class="breadcrumb-item active">Store Details</li>
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
                        <h4>{{ $store->brand_name }}</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill"
                                    href="#custom-content-above-home" role="tab"
                                    aria-controls="custom-content-above-home" aria-selected="true">Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill"
                                    href="#custom-content-above-profile" role="tab"
                                    aria-controls="custom-content-above-profile" aria-selected="false">Statistic</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-above-settings-tab" data-toggle="pill"
                                    href="#custom-content-above-settings" role="tab"
                                    aria-controls="custom-content-above-settings" aria-selected="false">Settings</a>
                            </li>
                        </ul>
                        <div class="mb-3">
                            {{-- <p class="lead mb-0">Custom Content goes here</p> --}}
                        </div>
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel"
                                aria-labelledby="custom-content-above-home-tab">
                                <dl>
                                    <dt>Code: </dt>
                                    <dd>{{ $store->code }}</dd>
                                    <dt>Description: </dt>
                                    <dd>{{ $store->business_description }}</dd>
                                    <dt>Facebook: </dt>
                                    <dd>{{ $store->facebook }}</dd>
                                    <dt>Instagram: </dt>
                                    <dd>{{ $store->instagram }}</dd>
                                    <dt>Twitter: </dt>
                                    <dd>{{ $store->twitter }}</dd>
                                    <dt>Youtube: </dt>
                                    <dd>{{ $store->youtube }}</dd>
                                    <dt>Website: </dt>
                                    <dd>{{ $store->website }}</dd>
                                </dl>

                            </div>
                            <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel"
                                aria-labelledby="custom-content-above-profile-tab">
                                <dl>
                                    <dt>Invoices Total: </dt>
                                    <dd>{{ $invoices->totalSum ?? 0 }}</dd>
                                    <dt>Invoices Count: </dt>
                                    <dd>{{ $invoices->rowCount }}</dd>
                                    <dt>Clients Wallets Points: </dt>
                                    <dd>{{ $wallets->pointsSum ?? 0 }}</dd>
                                    <dt>Clients Wallets Counts: </dt>
                                    <dd>{{ $wallets->rowCount }}</dd>
                                    <dt>Clients Rewards Counts: </dt>
                                    <dd>{{ $rewards->rowCount }}</dd>

                                </dl>
                            </div>
                            <div class="tab-pane fade" id="custom-content-above-settings" role="tabpanel"
                                aria-labelledby="custom-content-above-settings-tab">
                                <p> <b>Is Electronic Invoice: </b>
                                    @if ($store->is_electronic_invoice)
                                        <span style="color: green">Yes</span>
                                    @elseif($store->is_electronic_invoice == '0')
                                        <span style="color: red">No</span>
                                    @else
                                        Not set
                                    @endif
                                </p>
                                <p> <b>Is Invoice Coding: </b>
                                    @if ($store->is_invoice_coding)
                                        <span style="color: green">Yes</span>
                                    @elseif($store->is_invoice_coding == '0')
                                        <span style="color: red">No</span>
                                    @else
                                        Not set
                                    @endif
                                </p>
                                <p> <b>Is Invoice Has Code: </b>
                                    @if ($store->is_invoice_has_code)
                                        <span style="color: green">Yes</span>
                                    @elseif($store->is_invoice_has_code == '0')
                                        <span style="color: red">No</span>
                                    @else
                                        Not set
                                    @endif
                                </p>
                                <p> <b>Cashback: </b>
                                    @if ($store->cashback_enabled)
                                        <span style="color: green">Enabled</span>
                                        <p>-Cashback Percentage: {{ $store->cashback_percentage }}%</p>
                                    @elseif($store->cashback_enabled == '0')
                                        <span style="color: red">Disabled</span>
                                    @else
                                        Not set
                                    @endif
                                </p>
                                <p> <b>Loyalty: </b>
                                    @if ($store->loyalty_enabled)
                                        <span style="color: green">Enabled</span>
                                        <p>-Loyalty Type: {{ $store->loyalty_type }}</p>
                                        <p>-Loyalty Period: {{ $store->loyalty_period }} Months</p>
                                        <p>-Loyalty Expired: {{ $store->loyalty_expired }}</p>
                                        <p>-Loyalty Reward: @if($store->reward_type == 1) {{ $store->reward_name }} @else {{ $store->reward_points }} Points @endif </p>
                                    @elseif($store->loyalty_enabled == '0')
                                        <span style="color: red">Disabled</span>
                                    @else
                                        Not set
                                    @endif
                                </p>


                            </div>
                        </div>
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



