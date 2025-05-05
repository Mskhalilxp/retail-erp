<script>
    let imagesBasePath  = "{{ asset('/storage/Images') }}";
    let lightboxPath = "{{ asset('dashboard-assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}";
    let locale          = "{{ getLocale() }}";
</script>

<script src="{{asset('dashboard-assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{ asset('dashboard-assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{asset('dashboard-assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('js/translations.js')}}"></script>
<script src="{{asset('js/global_scripts.js')}}"></script>
@stack('scripts')

<!-- The core Firebase JS SDK is always required and must be listed first -->
{{-- <script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.7/firebase-analytics.js"></script>
<script src="{{ asset('js/dashboard/listen-to-firebase-notification.js') }}"></script> --}}
