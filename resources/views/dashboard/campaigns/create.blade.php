@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.campaigns.index') }}" class="text-muted text-hover-primary">{{ __("Campaigns") }}</a></h1>
                <!-- end :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Add new campaign") }}
                    </li>
                    <!-- end :: Item -->
                </ul>
                <!-- end :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end :: Subheader -->

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">
            <!-- begin :: Form -->
            <form action="{{ route('dashboard.campaigns.store') }}" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.campaigns.index') }}">
            @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __("Add new campaign") }}</h3>
                </div>
                <!-- end :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">
                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Name") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="name_inp" name="name" placeholder="example"/>
                                <label for="name_inp">{{ __("Enter the name") }}</label>
                            </div>
                            <p class="invalid-feedback" id="name" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Price") }}</label>
                            <div class="form-floating">
                                <input required type="number" min="1" class="form-control" id="price_inp" name="price" placeholder="example"/>
                                <label for="price_inp">{{ __("Enter the price") }}</label>
                            </div>
                            <p class="invalid-feedback" id="price" ></p>
                        </div>
                        <!-- end :: Column -->

                    </div>
                    <!-- end :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Start date") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control datepicker" id="start_date_inp" name="start_date" placeholder="example"/>
                                <label for="start_date_inp">{{ __("Enter start date") }}</label>
                            </div>
                            <p class="invalid-feedback" id="start_date" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("End date") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control datepicker" id="end_date_inp" name="end_date" placeholder="example"/>
                                <label for="end_date_inp">{{ __("Enter end date") }}</label>
                            </div>
                            <p class="invalid-feedback" id="end_date" ></p>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->
                </div>
                <!-- end :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __("Save") }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __("Please wait ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end :: Indicator -->

                    </button>
                    <!-- end :: Submit btn -->

                </div>
                <!-- end :: Form footer -->
            </form>
            <!-- end :: Form -->
        </div>
        <!-- end :: Card body -->
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            initDatePicker();
        });
    </script>
@endpush
