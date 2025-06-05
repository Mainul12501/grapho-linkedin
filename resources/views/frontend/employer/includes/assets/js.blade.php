<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap Bundle JS (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your Custom JS -->
<script src="{{ asset('/') }}frontend/employer/script.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    sweet alert js--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{!! Toastr::message() !!}


{{--common js functions made by me--}}
<script>
    function setInputValueByClassName(clickEventClassEle, targetClassEle, targetAttr) {
        $('.'+targetClassEle).val(clickEventClassEle.attr(targetAttr));
    }
</script>
@yield('script')
@stack('script')
