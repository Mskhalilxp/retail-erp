@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div  class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Orders") }}</h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Orders list") }}
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
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3 my-1 mb-3">
                    @if (isSuperAdmin())
                        <div class="d-flex">
                            <select class="form-select filter-datatable-inp w-225px mx-3" data-filter-index="9" data-control="select2" data-placeholder="{{ __("Created by") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                <option value=""></option>
                                @foreach ($admins->where('role', App\Enums\EmployeeRole::social_media->value) as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>

                            <select class="form-select filter-datatable-inp w-225px" data-filter-index="10" data-control="select2" data-placeholder="{{ __("Prepared by") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                <option value=""></option>
                                @foreach ($admins->where('role', App\Enums\EmployeeRole::warehouse->value) as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>

                            <select class="form-select filter-datatable-inp w-250px ms-3" data-filter-index="11" data-control="select2" data-placeholder="{{ __("Client contacted by") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                <option value=""></option>
                                @foreach ($admins->where('role', App\Enums\EmployeeRole::social_media->value) as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="d-flex">
                        <select class="form-select filter-datatable-inp w-225px" data-filter-index="8" data-control="select2" data-placeholder="{{ __("Select status") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                            <option value=""></option>
                            @foreach (App\Enums\OrderStatus::values() as $key => $value)
                                <option value="{{ $value }}">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</option>
                            @endforeach
                        </select>
                        {{-- @if (isWarehouse()) --}}
                        @if (auth('admin')->user()->role == \App\Enums\EmployeeRole::warehouse->value)
                            <div class="w-200px" >
                                <div class="form-floating">
                                    <input class="form-control form-control-solid border-gray-300 border-1 px-4 text-center filter-datatable-inp w-200px" data-filter-index="7" name="preparation_date" id="preparation_date_picker" />
                                    <label for="preparation_date_picker">{{ __("Preparation date") }}</label>
                                </div>
                            </div>
                        @endif

                        {{-- <div class="w-200px" >
                            <div class="form-floating">
                                <input class="form-control form-control-solid border-gray-300 border-1 px-4 text-center filter-datatable-inp date-range-picker" data-filter-index="12" name="delivery_date" id="delivery_date_picker" />
                                <label for="delivery_date_picker">{{ __("Delivery date") }}</label>
                            </div>
                        </div> --}}

                        @if (isSuperAdmin())
                            <div class="w-200px" >
                                <div class="form-floating">
                                    <input class="form-control form-control-solid border-gray-300 border-1 px-4 text-center filter-datatable-inp w-200px" data-filter-index="13" name="created_at" id="created_at_picker" />
                                    <label for="created_at_picker">{{ __("Creation Date") }}</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (isSocialMedia())
                        <!-- begin :: Add Button -->
                        <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary" data-bs-toggle="tooltip" title="">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                            {{ __("Add new order") }}
                        </a>
                        <!-- end   :: Add Button -->
                    @endif
                </div>
                <!-- end   :: General Search -->
            </div>
            <!-- end   :: Filter -->

            <!-- begin :: Datatable -->
            <table data-ordering="false" id="kt_datatable" class="table text-center table-row-dashed fs-6 gy-5" style="vertical-align: middle;">

                <thead>
                <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th class="min-w-100px">{{ __("Client name") }}</th>
                    <th class="min-w-100px">{{ __("Client mobile") }}</th>
                    <th class="min-w-100px">{{ __("City") }}</th>
                    <th class="min-w-100px">{{ __("Region") }}</th>
                    <th class="min-w-100px">{{ __("Sale price") }}</th>
                    <th class="min-w-100px">{{ __("Shipping status") }}</th>
                    <th class="min-w-100px">{{ __("Preparation date") }}</th>
                    <th class="min-w-100px">{{ __("Status") }}</th>
                    <th class="min-w-125px">{{ __("Created by") }}</th>
                    <th class="min-w-125px">{{ __("Prepared by") }}</th>
                    <th class="min-w-125px">{{ __("Client contacted by") }}</th>
                    <th class="min-w-100px">{{ __("Delivery date") }}</th>
                    <th class="min-w-100px">{{ __("Creation Date") }}</th>
                    <th class="min-w-125px">{{ __("actions") }}</th>
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
        let createdStatus = "{{ \App\Enums\OrderStatus::created->value }}";
        let preparedStatus = "{{ \App\Enums\OrderStatus::prepared->value }}";
        let returnedStatus = "{{ \App\Enums\OrderStatus::returned->value }}";
        let isSuperAdmin = "{{ auth('admin')->user()->role == \App\Enums\EmployeeRole::super_admin->value }}";
        let isSocialMedia = {{ isSocialMedia() }};
        $(document).ready(function () {
            let start    = moment();
            let end      = moment();

            $("#preparation_date_picker").daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: translate('Clear'),
                    applyLabel: translate('Apply'),
                },
                ranges: {
                    '{{ __('All') }}' : ["2024-01-01", moment().add(1,'year')],
                    '{{ __('Today') }}' : [moment(), moment()],
                    '{{ __('Tomorrow') }}' : [moment().add(1,'days'), moment().add(1,'days')],
                    '{{ __('Yesterday') }}' : [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    '{{ __('Last 7 Days') }}' : [moment().subtract(6, "days"), moment()],
                    '{{ __('Last 30 Days') }}' : [moment().subtract(29, "days"), moment()],
                    '{{ __('This Month') }}' : [moment().startOf("month"), moment().endOf("month")],
                    '{{ __('Last Month') }}' : [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            });

            $("#created_at_picker").daterangepicker({
                startDate: "2024-01-01",
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: translate('Clear'),
                    applyLabel: translate('Apply'),
                },
                ranges: {
                    '{{ __('All') }}' : ["2024-01-01", moment()],
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
    <script src="{{ asset('js/dashboard/datatables/orders.js') }}"></script>
@endpush
