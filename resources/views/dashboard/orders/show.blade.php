@extends('partials.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.orders.index') }}"
                    class="text-muted text-hover-primary">{{ __("Orders") }}</a></h1>
                <!-- end :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Order data") }}
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
                <h3 class="fw-bolder text-dark">{{ __("Order data") . " : #" . $order->id  }}</h3>
                @if ($order->status == App\Enums\OrderStatus::created->value && isWarehouse())
                    <form action="{{ route('dashboard.orders.change_status', $order->id) }}" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.orders.show', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" id="status_inp" value="prepared">
                        <p class="invalid-feedback" id="status" ></p>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <span class="indicator-label">{{ __("Preparation done") }}</span>
                            <!-- begin :: Indicator -->
                            <span class="indicator-progress">{{ __("Please wait ...") }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!-- end :: Indicator -->
                        </button>
                    </form>
                @endif
                @if ($order->status == App\Enums\OrderStatus::returned->value && isSocialMedia())
                    <form action="{{ route('dashboard.orders.change_status', $order->id) }}" id="client_contacted_form" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.orders.index') }}">
                        @csrf
                        <input type="hidden" name="status" id="status_inp" value="client_contacted">
                        <input type="hidden" name="client_notes" id="form_client_notes" value="">
                        <p class="invalid-feedback" id="status" ></p>
                        <button type="submit" class="btn btn-primary client_contacted_submit_btn" id="submit-btn">
                            <span class="indicator-label">{{ __("Client contacted") }}</span>
                            <!-- begin :: Indicator -->
                            <span class="indicator-progress">{{ __("Please wait ...") }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!-- end :: Indicator -->
                        </button>
                    </form>
                @endif
            </div>
            <!-- end :: Card header -->

            <!-- begin :: Inputs wrapper -->
            <div class="inputs-wrapper">
                @if (isSuperAdmin())
                    <h2 class="mb-5">{{ __('Data for admins') }}</h2>
                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Actual price") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->actual_price }}" placeholder="example" disabled/>
                                <label for="actual_price_inp">{{ __("Enter the actual price") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("QR ID") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->qr_id ?? '---' }}" placeholder="example" disabled/>
                                <label for="qr_id_inp">{{ __("QR ID") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Shipping status") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->shipping_status['name'] ?? '---' }}" placeholder="example" disabled/>
                                <label for="shipping_status_inp">{{ __("Shipping status") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Shipping price") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->shipping_price }}" placeholder="example" disabled/>
                                <label for="shipping_price_inp">{{ __("Shipping price") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Created by") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->socialEmployee->name }}" placeholder="example" disabled/>
                                <label for="sale_price_inp">{{ __("Created by") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Prepared by") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->warehouseEmployee?->name ?? '---' }}" placeholder="example" disabled/>
                                <label for="sale_price_inp">{{ __("Prepared by") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Client contacted by") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->contactEmployee?->name ?? '---' }}" placeholder="example" disabled/>
                                <label for="sale_price_inp">{{ __("Client contacted by") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Delivery date") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control" value="{{ $order->delivery_date ?? '---' }}" placeholder="example" disabled/>
                                <label for="sale_price_inp">{{ __("Delivery date") }}</label>
                            </div>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <hr class="mb-8">
                @endif

                <!-- begin :: Row -->
                <div class="row mb-8">
                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Client name") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control" id="client_name_inp" name="client_name" value="{{ $order->client_name }}" placeholder="example" disabled/>
                            <label for="client_name_inp">{{ __("Enter the name") }}</label>
                        </div>
                        <p class="invalid-feedback" id="client_name" ></p>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Client mobile") }}</label>
                        <div class="form-floating">
                            <input required dir="ltr" type="text" class="form-control" id="client_mobile_inp" name="client_mobile" value="{{ $order->client_mobile }}" placeholder="example" disabled/>
                            <label for="client_mobile_inp">{{ __("Enter the phone") }}</label>
                        </div>
                        <p class="invalid-feedback" id="client_mobile" ></p>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Status") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control" value="{{ $order->status_name }}" placeholder="example" disabled/>
                            <label>{{ __("Status") }}</label>
                        </div>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("City") }}</label>
                        <select required class="form-select" data-control="select2" name="city[id]" id="city_inp" data-placeholder="{{ __("Select city") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" disabled>
                            <option value=""></option>
                            <option value="{{ $order->city['id'] }}" selected>{{ $order->city['name'] }}</option>
                        </select>
                        <p class="invalid-feedback" id="city_id" ></p>
                    </div>
                    <input type="hidden" name="city[name]" id="city_name_inp">
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Region") }}</label>
                        <select required class="form-select" data-control="select2" name="region[id]" id="region_inp" data-placeholder="{{ __("Select region") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" disabled>
                            <option value=""></option>
                            <option value="{{ $order->region['id'] }}" selected>{{ $order->region['name'] }}</option>
                        </select>
                        <p class="invalid-feedback" id="region_id" ></p>
                    </div>
                    <input type="hidden" name="region[name]" id="region_name_inp">
                    <!-- end :: Column -->
                </div>
                <!-- end :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-8">
                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Address") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control" id="address_inp" name="address" value="{{ $order->address }}" placeholder="example" disabled/>
                            <label for="address_inp">{{ __("Enter the address") }}</label>
                        </div>
                        <p class="invalid-feedback" id="address" ></p>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Discount") }}</label>
                        <div class="form-floating">
                            <input type="number" min="1" class="form-control" id="discount_inp" name="discount" value="{{ $order->discount }}" placeholder="example" disabled/>
                            <label for="discount_inp">{{ __("Enter the discount") }}</label>
                        </div>
                        <p class="invalid-feedback" id="discount" ></p>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Preparation date") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control datepicker" id="preparation_date_inp" name="preparation_date" value="{{ $order->preparation_date }}" placeholder="example" disabled/>
                            <label for="preparation_date_inp">{{ __("Pick preparation date") }}</label>
                        </div>
                        <p class="invalid-feedback" id="preparation_date" ></p>
                    </div>
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Sale price") }}</label>
                        <div class="form-floating">
                            <input required type="text" class="form-control" value="{{ $order->sale_price }}" placeholder="example" disabled/>
                            <label for="sale_price_inp">{{ __("Enter the sale price") }}</label>
                        </div>
                    </div>
                    <!-- end :: Column -->
                </div>
                <!-- end :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-8">
                    <!-- begin :: Column -->
                    @if ($order->status == App\Enums\OrderStatus::returned->value && isSocialMedia())
                        <div class="col fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Client notes") }}</label>
                            <textarea id="client_notes_inp" rows="3" class="form-control" placeholder="{{ __('Enter client notes') }}">{{ $order->client_notes }}</textarea>
                            <p class="invalid-feedback" id="client_notes"></p>
                        </div>
                    @else
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Client notes") }}</label>
                            <textarea rows="3" class="form-control" placeholder="{{ __('Enter client notes') }}" disabled>{{ $order->client_notes }}</textarea>
                        </div>
                    @endif
                    <!-- end :: Column -->

                    <!-- begin :: Column -->
                    <div class="col fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __("Warehouse notes") }}</label>
                        <textarea id="warehouse_notes_inp" rows="3" class="form-control" placeholder="{{ __('Enter warehouse notes') }}" disabled>{{ $order->warehouse_notes }}</textarea>
                        <p class="invalid-feedback" id="warehouse_notes"></p>
                    </div>
                    <!-- end :: Column -->
                </div>
                <!-- end :: Row -->

                <hr>
                <h1>{{ __('Products') }}</h1>

                @if ($order->status == App\Enums\OrderStatus::prepared->value && isWarehouse())
                    <form action="{{ route('dashboard.orders.change_status', $order->id) }}" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.orders.index') }}">
                        @csrf
                        <p class="invalid-feedback text-center" id="return_quantity" ></p>
                        <div class="d-flex justify-content-end">
                            <div class="text-center">
                                <!-- begin :: Submit btn -->
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span class="indicator-label">{{ __("Save changes") }}</span>
                                    <!-- begin :: Indicator -->
                                    <span class="indicator-progress">{{ __("Please wait ...") }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    <!-- end :: Indicator -->
                                </button>
                                <!-- end :: Submit btn -->
                            </div>
                        </div>
                        <!-- begin :: Row -->
                        <div class="row mb-8">
                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">{{ __("Status") }}</label>
                                <select class="form-select" name="status" id="status_inp" data-control="select2" data-placeholder="{{ __("Select status") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                    <option value=""></option>
                                    <option value="{{ str_replace('_', ' ', App\Enums\OrderStatus::delivered->name) }}">{{ __(ucfirst(str_replace('_', ' ', App\Enums\OrderStatus::delivered->name))) }}</option>
                                    <option value="{{ str_replace('_', ' ', App\Enums\OrderStatus::returned->name) }}">{{ __(ucfirst(str_replace('_', ' ', App\Enums\OrderStatus::returned->name))) }}</option>
                                </select>
                                <p class="invalid-feedback" id="status" ></p>
                            </div>
                            <!-- end :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">{{ __("Warehouse notes") }}</label>
                                <textarea id="warehouse_notes_inp" name="warehouse_notes" rows="3" class="form-control" placeholder="{{ __('Enter warehouse notes') }}"></textarea>
                                <p class="invalid-feedback" id="warehouse_notes"></p>
                            </div>
                            <!-- end :: Column -->
                        </div>
                        <!-- end :: Row -->
                @endif

                <div class="row mb-8 justify-content-center" id="products-container">
                    @foreach ($order->products as $orderProduct)
                        <div class="border-secondary border rounded w-75 px-4 {{ $loop->index != 0 ? 'mt-5' : '' }}" id="product-{{ $loop->iteration }}">
                            <!-- begin :: Row -->
                            <div class="row my-5">
                                <!-- begin :: Column -->
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-bold mb-2">
                                        {{ __("Product") }}
                                        <a href="{{ route('dashboard.products.show', $orderProduct->id) }}" class="fs-7" target="_blank">
                                            {{ __("Details") }}
                                        </a>
                                    </label>
                                    <select required class="form-select" data-control="select2" name="products[{{ $loop->index }}][id]" id="products_{{ $loop->index }}_id_inp" data-placeholder="{{ __("Select product") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}"disabled >
                                        <option value="{{ $orderProduct->id }}" selected>{{ $orderProduct->name }}</option>
                                    </select>

                                    <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $orderProduct->id }}" id="products_{{ $loop->index }}_id_inp">
                                </div>
                                <!-- end :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-3 fv-row">
                                    <label class="required fs-5 fw-bold mb-2">{{ __("Quantity") }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control quantity-inp" id="products_{{ $loop->index }}_quantity_inp" data-index="{{ $loop->index }}" name="products[{{ $loop->index }}][quantity]" value="{{ $orderProduct->pivot->quantity }}" placeholder="example" disabled/>
                                        <label for="products_{{ $loop->index }}_quantity_inp">{{ __("Enter the quantity") }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="products_{{ $loop->index }}_quantity" ></p>
                                </div>
                                <!-- end :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-3 fv-row">
                                    <label class="required fs-5 fw-bold mb-2">{{ __("Sale price") }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="products_{{ $loop->index }}_sale_price_inp" data-index="{{ $loop->index }}" name="products[{{ $loop->index }}][sale_price]" value="{{ $orderProduct->pivot->sale_price }}" placeholder="example" disabled/>
                                        <label for="products_{{ $loop->index }}_sale_price_inp">{{ __("Enter the sale price") }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="products_{{ $loop->index }}_sale_price" ></p>
                                </div>
                                <!-- end :: Column -->
                            </div>
                            <!-- end :: Row -->
                        </div>
                    @endforeach
                </div>

                @if ($order->status == App\Enums\OrderStatus::prepared->value && isWarehouse())
                    </form> {{-- To include products in the form request when status is returned so can update it in order & quantity --}}
                @endif
            </div>
            <!-- end :: Inputs wrapper -->

            <!-- begin :: Form footer -->
            <div class="form-footer">
                <!-- begin :: Submit btn -->
                <a href="{{ route('dashboard.orders.index') }}" class="btn btn-primary" >
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
    <script>
        $(document).ready(function () {
            let warehouseNotesInp = $("#warehouse_notes_inp");
            $("#status_inp").change(function (e) {
                e.preventDefault();
                let status = $(this).val();

                if(status == "returned") {
                    warehouseNotesInp.attr('required',true);
                    $("textarea[name='warehouse_notes']").prev().addClass('required');
                    $("input[id$='_quantity_inp']").attr('disabled', false);
                } else {
                    warehouseNotesInp.attr('required',false);
                    $("textarea[name='warehouse_notes']").prev().removeClass('required');
                    $("input[id$='_quantity_inp']").attr('disabled', true);
                }
            });

            $(".client_contacted_submit_btn").on('click', function (e) {
                e.preventDefault();
                let clientNotesInp = $("#client_notes_inp");

                if(clientNotesInp.val() == "")
                {
                    clientNotesInp.addClass('is-invalid');
                    document.getElementById('client_notes_inp').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    $("#client_notes").html("{{ __('Enter client notes') }}").css('display','block');
                }
                else
                {
                    clientNotesInp.removeClass('is-invalid');
                    $("#client_notes").css('display','none');
                    $("#form_client_notes").val(clientNotesInp.val());
                    $("#client_contacted_form").submit();
                }
            });

        });
    </script>
@endpush
