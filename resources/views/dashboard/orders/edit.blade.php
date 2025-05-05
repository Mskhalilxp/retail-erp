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
                        {{ __("Edit order data") }}
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
            <form action="{{ route('dashboard.orders.update',$order->id) }}" class="form submitted-form" method="post"  data-redirection-url="{{ route('dashboard.orders.index') }}">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __("Edit order data") . " : #" . $order->id  }}</h3>
                </div>
                <!-- end :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">
                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Client name") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="client_name_inp" name="client_name" value="{{ $order->client_name }}" placeholder="example"/>
                                <label for="client_name_inp">{{ __("Enter the name") }}</label>
                            </div>
                            <p class="invalid-feedback" id="client_name" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Client mobile") }}</label>
                            <div class="form-floating">
                                <input required dir="ltr" type="text" class="form-control" id="client_mobile_inp" name="client_mobile" value="0{{ substr($order->client_mobile, 4) }}" placeholder="example"/>
                                <label for="client_mobile_inp">{{ __("Enter the phone") }}</label>
                            </div>
                            <p class="invalid-feedback" id="client_mobile" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("City") }}</label>
                            <select required class="form-select" data-control="select2" name="city[id]" id="city_inp" data-placeholder="{{ __("Select city") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value=""></option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['id'] }}" {{ $order->city['id'] == $city['id'] ? 'selected' : '' }}>{{ $city['city_name'] }}</option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="city_id" ></p>
                        </div>
                        <input type="hidden" name="city[name]" value="{{ $order->city['name'] }}" id="city_name_inp">
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Region") }}</label>
                            <select required class="form-select" data-control="select2" name="region[id]" id="region_inp" data-placeholder="{{ __("Select region") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option value=""></option>
                                <option value="{{ $order->region['id'] }}" selected>{{ $order->region['name'] }}</option>
                            </select>
                            <p class="invalid-feedback" id="region_id" ></p>
                        </div>
                        <input type="hidden" name="region[name]" value="{{ $order->region['name'] }}" id="region_name_inp">
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Address") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="address_inp" name="address" value="{{ $order->address }}" placeholder="example"/>
                                <label for="address_inp">{{ __("Enter the address") }}</label>
                            </div>
                            <p class="invalid-feedback" id="address" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Discount") }}</label>
                            <div class="form-floating">
                                <input type="number" min="1" class="form-control" id="discount_inp" name="discount" value="{{ $order->discount }}" placeholder="example" />
                                <label for="discount_inp">{{ __("Enter the discount") }}</label>
                            </div>
                            <p class="invalid-feedback" id="discount" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="required fs-5 fw-bold mb-2">{{ __("Preparation date") }}</label>
                            <div class="form-floating">
                                <input required type="text" class="form-control datepicker" id="preparation_date_inp" name="preparation_date" value="{{ $order->preparation_date }}" placeholder="example" />
                                <label for="preparation_date_inp">{{ __("Pick preparation date") }}</label>
                            </div>
                            <p class="invalid-feedback" id="preparation_date" ></p>
                        </div>
                        <!-- end :: Column -->

                        <!-- begin :: Column -->
                        <div class="col fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __("Client notes") }}</label>
                            <textarea id="client_notes_inp" name="client_notes" rows="3" class="form-control" placeholder="{{ __('Enter client notes') }}" >{{ $order->client_notes }}</textarea>
                            <p class="invalid-feedback" id="client_notes"></p>
                        </div>
                        <!-- end :: Column -->
                    </div>
                    <!-- end :: Row -->

                    <hr>
                    <h1>{{ __('Products') }}</h1>

                    <div class="row justify-content-center mb-8 mt-5">
                        <button class="btn bg-primary w-auto text-white" type="button" onclick="addProduct('product')">
                            <i class="fas fa-plus text-white" aria-hidden="true"></i> {{ __('Add new product') }}
                        </button>
                    </div>

                    <p class="invalid-feedback text-center" id="products" ></p>

                    <div class="row mb-8 justify-content-center" id="products-container">
                        @foreach ($order->products as $orderProduct)
                            <div class="border-secondary border rounded w-75 px-4 {{ $loop->index != 0 ? 'mt-5' : '' }}" id="product-{{ $loop->iteration }}">
                                <!-- begin :: Row -->
                                <div class="row my-5 align-items-center">
                                    <!-- begin :: Column -->
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">
                                            {{ __("Product") }}
                                        </label>
                                        <select required class="form-select" data-control="select2" name="products[{{ $loop->index }}][id]" id="products_{{ $loop->index }}_id_inp" data-placeholder="{{ __("Select product") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}"" >
                                            <option value="{{ $orderProduct->id }}" selected>{{ $orderProduct->name }}</option>
                                        </select>

                                        <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $orderProduct->id }}" id="products_{{ $loop->index }}_id_inp">
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-5 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">{{ __("Quantity") }}</label>
                                        <div class="form-floating">
                                            <input type="text" class="form-control quantity-inp" id="products_{{ $loop->index }}_quantity_inp" data-index="{{ $loop->index }}" name="products[{{ $loop->index }}][quantity]" value="{{ $orderProduct->pivot->quantity }}" placeholder="example"/>
                                            <label for="products_{{ $loop->index }}_quantity_inp">{{ __("Enter the quantity") }}</label>
                                        </div>
                                        <p class="invalid-feedback" id="products_{{ $loop->index }}_quantity" ></p>
                                    </div>
                                    <!-- end :: Column -->

                                    <!-- begin :: Column -->
                                <div class="col-md-1 fv-row text-center">
                                    <button class="btn px-2" type="button" onclick="deleteProduct({{ $loop->iteration }})">
                                        <i class="fas fa-trash text-danger fs-2"></i>
                                    </button>
                                </div>
                                <!-- end :: Column -->
                                </div>
                                <!-- end :: Row -->
                            </div>
                        @endforeach
                    </div>
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
            initDatePicker('preparation_date_inp', '{{ $order->preparation_date }}');

            $("#city_inp").change(function (e) {
                e.preventDefault();

                let cityId = $(this).val();

                $("#city_name_inp").val($( "#city_inp option:selected" ).text());
                $("#region_inp").attr('disabled', true);

                if(cityId)
                {
                    $.ajax({
                        url: `/city/${cityId}/regions`,
                        success: function (response) {
                            $("#region_inp").empty();
                            $("#region_inp").append($('<option>', {
                                value: "",
                                text: "{{ __('Select region') }}",
                            }));
                            $.each(response, function (index, region) {
                                $("#region_inp").append($('<option>', {
                                    value: region.id,
                                    text: region.region_name,
                                }));
                            });
                            $("#region_inp").attr('disabled', false);
                        },
                        error: function (error) {
                            errorAlert(error.responseJSON.message);
                        }
                    });
                }
            });

            $("#region_inp").change(function (e) {
                e.preventDefault();
                let regionId = $(this).val();

                $("#region_name_inp").val($( "#region_inp option:selected" ).text());
            });
        });

        let addProduct = () => {
            let productsContainer = $(`#products-container`);
            let index = productsContainer.children().length;
            productHtml = `
                    <div class="border-secondary border rounded w-75 px-4 ${index != 0 ? 'mt-5' : ''}" id="product-${index + 1}">
                        <!-- begin :: Row -->
                            <div class="row my-5 align-items-center">
                                <!-- begin :: Column -->
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-bold mb-2">{{ __("Product") }}</label>
                                    <select required class="form-select" data-control="select2" name="products[${index}][id]" id="products_${index}_id_inp" data-placeholder="{{ __("Select product") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" >
                                        <option value=""></option>
                                        @foreach (App\Models\Product::get() as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="invalid-feedback" id="products_${index}_id" ></p>
                                </div>
                                <!-- end :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-5 fv-row">
                                    <label class="required fs-5 fw-bold mb-2">{{ __("Quantity") }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control quantity-inp" id="products_${index}_quantity_inp" data-index="${index}" name="products[${index}][quantity]" placeholder="example"/>
                                        <label for="products_${index}_quantity_inp">{{ __("Enter the quantity") }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="products_${index}_quantity" ></p>
                                </div>
                                <!-- end :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-1 fv-row text-center">
                                    <button class="btn px-2" type="button" onclick="deleteProduct(${index + 1})">
                                        <i class="fas fa-trash text-danger fs-2"></i>
                                    </button>
                                </div>
                                <!-- end :: Column -->
                            </div>
                        <!-- end :: Row -->
                    </div>`;

            productsContainer.append(productHtml).hide().fadeIn(300);
            $(`#products_${index}_id_inp`).val(null)
            $(`#products_${index}_id_inp`).select2().trigger('change');

            // $(`#product-${index}`).find('.fas.fa-trash.text-danger').hide();
        }

        let deleteProduct = (id) => {
            $(`#product-${id}`).fadeOut(300, function () {
                $(this).remove();
            })
            // $(`#product-${id}`).prev().find('.fas.fa-trash.text-danger').show();
        }
    </script>
    <script>
        const input = document.getElementById('client_mobile_inp');

        input.addEventListener('paste', function (e) {
            e.preventDefault(); // نمنع اللصق العادي
            let clipboardData = (e.clipboardData || window.clipboardData).getData('text');

          // تحويل الأرقام العربية إلى إنجليزية
            const convertArabicNumbers = (str) => {
                return str.replace(/[\u0660-\u0669\u06F0-\u06F9]/g, (d) => {
                return String.fromCharCode(d.charCodeAt(0) & 0xf);
                });
            };

            let normalizedText = convertArabicNumbers(clipboardData);

            // استخراج رقم الهاتف من النص (أي رقم مكون من 7 إلى 15 رقم متتالية)
            let phoneNumber = normalizedText.match(/\b\d{7,15}\b/);

            if (phoneNumber) {
                input.value = phoneNumber[0];
            } else {
            input.value = "";
            alert("No valid phone number found in the copied text.");
            }
        });
    </script>
@endpush
