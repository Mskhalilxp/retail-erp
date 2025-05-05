@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div  class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Campaigns") }}</h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Campaigns list") }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!-- begin :: Datatable card -->
    <div class="card mb-2">
        <!-- begin :: Card Body -->
        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

            <!-- begin :: Filter -->
            <div class="d-flex flex-stack flex-wrap mb-15">

                <!-- begin :: General Search -->
                <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <i class="fa fa-search fa-lg" ></i>
                    </span>

                    <input type="text" class="form-control form-control-solid w-250px ps-15 border-gray-300 border-1 me-4" id="general-search-inp" placeholder="{{ __("Search ...") }}">
                    <div class="d-flex w-350px justify-content-around">
                        <div class="form-floating">
                            <input type="text" class="form-control datepicker filter-datatable-inp" data-filter-index="3" id="start_date_inp" name="start_date" placeholder="example"/>
                            <label for="start_date_inp">{{ __("From date") }}</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control datepicker filter-datatable-inp" data-filter-index="4" id="end_date_inp" name="end_date" placeholder="example"/>
                            <label for="end_date_inp">{{ __("To date") }}</label>
                        </div>
                    </div>
                </div>
                <!-- end   :: General Search -->

                <!-- begin :: Toolbar -->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!-- begin :: Add Button -->
                    <a href="{{ route('dashboard.campaigns.create') }}" class="btn btn-primary" data-bs-toggle="tooltip" title="">
                        <span class="svg-icon svg-icon-2">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>

                        {{ __("Add new campaign") }}
                    </a>
                    <!-- end   :: Add Button -->
                </div>
                <!-- end   :: Toolbar -->
            </div>
            <!-- end   :: Filter -->

            <!-- begin :: Datatable -->
            <table data-ordering="false" id="kt_datatable" class="table text-center table-row-dashed fs-6 gy-5" style="vertical-align: middle;">

                <thead>
                <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Price") }}</th>
                    <th>{{ __("Start date") }}</th>
                    <th>{{ __("End date") }}</th>
                    <th>{{ __("Creation Date") }}</th>
                    <th class="min-w-100px">{{ __("actions") }}</th>
                </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold text-center">

                </tbody>

            </table>
            <!-- end   :: Datatable -->


        </div>
        <!-- end   :: Card Body -->
    </div>
    <!-- end   :: Datatable card -->

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            // initDatePicker("start_date_inp", moment().subtract(10, 'y').format('YYYY-MM-DD'));
            initDatePicker("start_date_inp", "{{ now()->subYear()->format('Y-m-d') }}");
            initDatePicker("end_date_inp", "{{ now()->addYear()->format('Y-m-d') }}");
            // initDatePicker("end_date_inp", moment().add(10, 'y').format('YYYY-MM-DD'));
        });
    </script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/campaigns.js') }}"></script>
@endpush
