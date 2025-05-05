@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar" >
        <!--begin::Container-->
        <div  class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Dashboard") }}
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->

                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">{{ __('Reports') }}</small>
                <!--end::Description-->
            </h1>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!-- end   :: Subheader -->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid" >
        <!--begin::Container-->
        <div class="container">
            {{-- <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-list" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Total orders") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-user-check" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Delivered orders") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::delivered->value)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-user-xmark" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Orders with problems") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->whereIn('shipping_status.id', [25,26,27,30,31,32,33,36,37,39])->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-truck" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Out for delivery") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('shipping_status.id', 3)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-boxes-stacked" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Prepared") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::prepared->value)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fa fa-undo" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Returned") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::returned->value)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-phone-volume" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Client contacted") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::client_contacted->value)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-column align-items-center flex-grow-1 card-p">
                                <i class="text-primary fas fa-coins" style="font-size: 40px;"></i>
                                <div class="d-flex justify-content-between w-100 mt-5">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Total earnings") }}</a>
                                    <span class="px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->sum('sale_price') - ($orders->sum('actual_price') + $orders->sum('shipping_price')) }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <!--end::Row--> --}}

            <!----------------------------------------------------------------------------------------------------------->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <form action="{{ route('dashboard.index') }}">
                    <div class="col-xl-12 px-2">
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <div class="form-floating">
                                            <input type="text" class="form-control datepicker" id="start_date_inp" name="start_date" value="{{ request('start_date') }}" placeholder="example"/>
                                            <label for="start_date_inp">{{ __("Enter start date") }}</label>
                                        </div>
                                        <p class="invalid-feedback" id="start_date" ></p>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <div class="form-floating">
                                            <input type="text" class="form-control datepicker" id="end_date_inp" name="end_date" value="{{ request('end_date') }}" placeholder="example"/>
                                            <label for="end_date_inp">{{ __("Enter end date") }}</label>
                                        </div>
                                        <p class="invalid-feedback" id="end_date" ></p>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="rent_inp" name="rent" value="{{ request('rent') }}" placeholder="example"/>
                                            <label for="rent_inp">{{ __("Enter the rent") }}</label>
                                        </div>
                                        <p class="invalid-feedback" id="rent" ></p>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="salaries_inp" name="salaries" value="{{ request('salaries') }}" placeholder="example"/>
                                            <label for="salaries_inp">{{ __("Enter the salaries") }}</label>
                                        </div>
                                        <p class="invalid-feedback" id="salaries" ></p>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <select required class="form-select" name="year" id="year_inp" data-placeholder="{{ __("Select year") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                            <option value=""></option>
                                            @for ($year = 2025 ; $year <= date('Y') ; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-2 fv-row">
                                        <button type="submit" class="btn btn-primary w-100 h-100">
                                            <i class="fas fa-filter"></i>
                                            {{ __("فـلـتـر") }}
                                        </button>
                                    </div>
                                    <!-- end :: Column -->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </form>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-list" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Total orders") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-user-check" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Delivered orders") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::delivered->value)->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-user-xmark" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Orders with problems") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->whereIn('shipping_status.id', [25,26,27,30,31,32,33,36,37,39])->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-truck" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Out for delivery") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('shipping_status.id', 3)->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-boxes-stacked" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Prepared") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::prepared->value)->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fa fa-undo" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Returned") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::returned->value)->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-phone-volume" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Client contacted") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->where('status', App\Enums\OrderStatus::client_contacted->value)->count() }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-xl-3 px-2">
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <i class="text-primary fas fa-coins" style="font-size: 40px;"></i>
                                <a href="#" class="mt-3 text-dark text-hover-primary fw-bolder fs-3">{{ __("Total earnings") }}</a>
                                <span class="mt-4 px-3 fs-3 fw-bolder bg-light-primary text-primary">{{ $orders->sum('sale_price') - ($orders->sum('actual_price') + $orders->sum('shipping_price')) - (request('rent') + request('salaries')) }}</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-stack flex-grow-1 card-p">
                                <div class="d-flex flex-column me-2">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Total orders") }}</a>
                                </div>
                                <span class="symbol symbol-50px">
                                    <span class="symbol-label fs-5 fw-bolder bg-light-primary text-primary">{{ array_sum($ordersMonthlyRate['data']) }}</span>
                                </span>
                            </div>
                            <div class="card-rounded-bottom" id="orders_chart" data-kt-chart-color="primary" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-stack flex-grow-1 card-p">
                                <div class="d-flex flex-column me-2">
                                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">{{ __("Total earnings") }}</a>
                                </div>
                                <span class="symbol symbol-50px">
                                    <span class="symbol-label fs-5 fw-bolder bg-light-primary text-primary">{{ array_sum($totalEarningsPerMonth['data']) }}</span>
                                </span>
                            </div>
                            <div class="card-rounded-bottom" id="total_earnings_chart" data-kt-chart-color="primary" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8 mt-5">
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <a href="#" class="text-dark text-hover-primary text-center mt-10 fw-bolder fs-4">
                                {{ __("Total orders per city") }}
                            </a>
                            @if( count($ordersCitiesPercentage) == 0 )
                                <p class="text-dark text-hover-primary text-center my-10 fw-boldest mt-20 fs-3">{{ __("There are no orders yet") }}</p>
                            @endif
                            <div id="orders_cities_pie_chart" class="h-400px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                        <a href="#" class="text-dark text-hover-primary text-center mt-10 fw-bolder fs-4">
                            {{ __("Total orders per product") }}
                        </a>
                            @if( count($productsOrdersPercentage) == 0 )
                                <p class="text-dark text-hover-primary text-center my-10 fw-boldest mt-20 fs-3">{{ __("There are no orders yet") }}</p>
                            @endif
                            <div id="products_orders_pie_chart" class="h-400px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8 mt-5">
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <a href="#" class="text-dark text-hover-primary text-center my-10 fw-bolder fs-4">
                                {{ __("Top 5 products") }}
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-4 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-center text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>{{ __("Name") }}</th>
                                        <th>{{ __("Total orders") }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($top5Products as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('dashboard.products.show', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td>{{ $product->orders_count }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </a>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection
@push('scripts')
    <script>
        let totalEarningsPerMonth = @json($totalEarningsPerMonth);
        let ordersMonthlyRate = @json($ordersMonthlyRate);
        let ordersCitiesPercentage = @json($ordersCitiesPercentage);
        let productsOrdersPercentage = @json($productsOrdersPercentage);
        $(document).ready(function () {
            initDatePicker("start_date_inp", '{{ request('start_date') }}');
            initDatePicker("end_date_inp", '{{ request('end_date') }}');
            $("#year_inp").val("{{ request('year') ?? date('Y') }}").trigger('change');
        });
    </script>
    <script src="{{ asset('dashboard-assets') }}/js/widgets.bundle.js"></script>
    <script src="{{ asset('dashboard-assets') }}/js/custom/widgets.js"></script>

    <script src="{{ asset('dashboard-assets') }}/plugins/custom/flotcharts/flotcharts.bundle.js"></script>

    <script src="{{asset('js/dashboard/statistics.js')}}"></script>

@endpush
