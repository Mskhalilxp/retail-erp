@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.products.index') }}" class="text-muted text-hover-primary">{{ __("Products") }}</a></h1>
                <!-- end :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Add new product") }}
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
            <form action="{{ route('dashboard.products.store') }}" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.products.index') }}">
            @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __("Add new product") }}</h3>
                </div>
                <!-- end :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">
                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex flex-column align-items-center">
                            <div class="d-flex flex-column">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __("Image") }}</label>
                                <x-dashboard.upload-image-inp name="image" :image="null" :directory="null" placeholder="default.svg" type="editable" ></x-dashboard.upload-image-inp>
                                <!-- end   :: Upload image component -->
                            </div>
                            <p class="invalid-feedback text-center" id="image" ></p>
                        </div>
                        <!-- end   :: Column -->
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Name") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="name_inp" name="name" placeholder="example"/>
                                <label for="name_inp">{{ __("Enter the name") }}</label>
                            </div>
                            <p class="invalid-feedback" id="name" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Quantity") }}</label>
                            <div class="form-floating">
                                <input required type="number" min="1" class="form-control" id="quantity_inp" name="quantity" placeholder="example"/>
                                <label for="quantity_inp">{{ __("Enter the quantity") }}</label>
                            </div>
                            <p class="invalid-feedback" id="quantity" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Store") }}</label>
                            <select required class="form-select" data-control="select2" name="store_id" id="store_id_inp" data-placeholder="{{ __("Select store") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                <option value=""></option>
                                @foreach (App\Models\Store::get() as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="store_id" ></p>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Actual price") }}</label>
                            <div class="form-floating">
                                <input required type="number" min="1" class="form-control" id="actual_price_inp" name="actual_price" placeholder="example"/>
                                <label for="actual_price_inp">{{ __("Enter the actual price") }}</label>
                            </div>
                            <p class="invalid-feedback" id="actual_price" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Sale price") }}</label>
                            <div class="form-floating">
                                <input required type="number" min="1" class="form-control" id="sale_price_inp" name="sale_price" placeholder="example"/>
                                <label for="sale_price_inp">{{ __("Enter the sale price") }}</label>
                            </div>
                            <p class="invalid-feedback" id="sale_price" ></p>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Details") }}</label>
                            <textarea id="details_inp" name="details" rows="5" class="form-control" placeholder="{{ __('Enter the details') }}"></textarea>
                            <p class="invalid-feedback" id="details"></p>
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
