@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div  class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Stocks") }}</h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Stocks list") }}
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
                <div class="d-flex align-items-center my-1 mb-2 mb-md-0">
                    <div class="d-flex me-2">
                        <div class="w-200px" >
                            <div class="form-floating">
                                <input class="form-control form-control-solid border-gray-300 border-1 px-4 text-center filter-datatable-inp" data-filter-index="3" name="delivery_date" id="from_to_dp" />
                                <label for="products_0_quantity_inp">{{ __("Delivery date") }}</label>
                            </div>
                        </div>
                    </div>

                    <select class="form-select filter-datatable-inp w-200px" data-filter-index="4" data-control="select2" data-placeholder="{{ __("Select status") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                        <option value=""></option>
                        @foreach (App\Enums\StockStatus::values() as $key => $value)
                            <option value="{{ $value }}">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- end   :: General Search -->

                <!-- begin :: Toolbar -->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!-- begin :: Add Button -->
                    <a href="{{ route('dashboard.stocks.create') }}" class="btn btn-primary" data-bs-toggle="tooltip" title="">
                        <span class="svg-icon svg-icon-2">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>

                        {{ __("Add new stock") }}
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
                    <th>{{ __("Price") }}</th>
                    <th>{{ __("Delivery price") }}</th>
                    <th>{{ __("Delivery date") }}</th>
                    <th>{{ __("Status") }}</th>
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
            initDatePicker();

            let fromToDp = $("#from_to_dp");
            let start    = moment();
            let end      = moment().add(1, 'year');

            fromToDp.daterangepicker({
                startDate: '2024-01-01',
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                ranges: {
                    '{{ __('All') }}' : ["2024-01-01", end],
                    '{{ __('Today') }}' : [moment(), moment()],
                    '{{ __('Tomorrow') }}' : [moment().add(1,'days'), moment().add(1,'days')],
                    '{{ __('Yesterday') }}' : [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    '{{ __('Last 7 Days') }}' : [moment().subtract(6, "days"), moment()],
                    '{{ __('Last 30 Days') }}' : [moment().subtract(29, "days"), moment()],
                    '{{ __('This Month') }}' : [moment().startOf("month"), moment().endOf("month")],
                    '{{ __('Last Month') }}' : [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            });
            $('li[data-range-key="Custom Range"]').html( '{{ __('Custom Range') }}' ) // translate 'Custom Range'
        });
    </script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/stocks.js') }}"></script>
@endpush
