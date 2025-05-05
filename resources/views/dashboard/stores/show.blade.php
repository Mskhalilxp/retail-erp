@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.stores.index') }}"
                    class="text-muted text-hover-primary">{{ __("Stores") }}</a></h1>
                <!-- end :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Store data") }}
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
            <!-- begin :: Card header -->
            <div class="card-header d-flex align-items-center">
                <h3 class="fw-bolder text-dark">{{ __("Store data") . " : " . $store->name  }}</h3>
            </div>
            <!-- end :: Card header -->

            <div class="inputs-wrapper">
                <!-- begin :: Row -->
                <div class="row mb-8">
                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row d-flex flex-column align-items-center">
                        <div class="d-flex flex-column">
                            <!-- begin :: Upload image component -->
                            <label class="text-center fw-bold mb-4">{{ __("Logo") }}</label>
                            <x-dashboard.upload-image-inp name="logo" :image="$store->logo" directory="Stores" placeholder="default.svg" type="show" ></x-dashboard.upload-image-inp>
                            <!-- end   :: Upload image component -->
                        </div>
                        <p class="invalid-feedback text-center" id="logo" ></p>
                    </div>
                    <!-- end   :: Column -->
                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-8 justify-content-center">
                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-5 fw-bold mb-2">{{ __("Name") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control" id="name_inp" name="name" value="{{ $store->name }}" placeholder="example" disabled/>
                            <label for="name_inp">{{ __("Enter the name") }}</label>
                        </div>
                        <p class="invalid-feedback" id="name" ></p>
                    </div>
                    <!-- end :: Column -->
                </div>
                <!-- end :: Row -->
                <hr></hr>
                <h2 class="fw-bold"> {{ __("Products") }}</h2>
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <tr class="text-center text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>{{ __("Image") }}</th>
                                <th>{{ __("Name") }}</th>
                                <th>{{ __("Quantity") }}</th>
                                <th>{{ __("Actual price") }}</th>
                                <th>{{ __("Sale price") }}</th>
                                <th>{{ __("Details") }}</th>
                                <th>{{ __("Creation Date") }}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ getImagePath($product->image, "Products/$product->store_id") }}">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded" style="height:56px;width:100px;border-radius:4px;margin:auto;background-image:url('{{ getImagePath($product->image, "Products/$product->store_id") }}');background-size:contain;">
                                            </div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div style="width:47px;height:47px;margin: auto;" class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('dashboard.products.show', $product->id) }}" target="_blank">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                    <td class="text-center">{{ $product->actual_price }}</td>
                                    <td class="text-center">{{ $product->sale_price }}</td>
                                    <td class="text-center">{{ $product->details }}</td>
                                    <td class="text-center">{{ $product->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <h3 class="text-center py-5">
                                            {{ __('No products to show') }}
                                        </h3>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!--end::Table-->
                    <div class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </div>
                </div>

            </div>

            <!-- begin :: Form footer -->
            <div class="form-footer">
                <!-- begin :: Submit btn -->
                <a href="{{ route('dashboard.stores.index') }}" class="btn btn-primary" >
                    <span class="indicator-label">{{ __("Back") }}</span>
                </a>
                <!-- end :: Submit btn -->
            </div>
            <!-- end :: Form footer -->
        </div>
        <!-- end :: Card body -->
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('dashboard-assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
@endpush
