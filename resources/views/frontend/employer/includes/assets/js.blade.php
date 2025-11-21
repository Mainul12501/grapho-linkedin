<!-- slim js -->
{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
<script src="{{ asset('/') }}common-assets/js/jquery-3.7.1.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>--}}

<!-- Bootstrap Bundle JS (with Popper) -->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{ asset('/') }}common-assets/js/bootstrap.bundle-5.3.6.min.js"></script>

<!-- Your Custom JS -->
<script src="{{ asset('/') }}frontend/employer/script.js"></script>

<!-- Toastr JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>
{{--    sweet alert js--}}
{{--<script src="{{ asset('/') }}common-assets/js/sweetalert2@11-11.22.0.js"></script>--}}
<!-- Sweet Alert JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>--}}

{{--    sweet alert js--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--    delete popup with sweet alert--}}
<script>
    $(document).on('click', '.data-delete-form', function () {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                $(this).parent().submit();
            }

        })
    })
</script>
{!! Toastr::message() !!}



<script>
    var base_url = "{!! url('/') !!}/";

    let response;

    function sendAjaxRequest(url, method, data = {}) {
        return $.ajax({ // Return the Promise from $.ajax
            url: base_url + url,
            method: method,
            data: data
        })
            .done(function (data) { // .done() for success
                // console.log(data);
                // No need to assign to 'response' here, it's passed to .then()
            })
            .fail(function (error) { // .fail() for error
                toastr.error(error);
                // The error will also be propagated to the .catch() when called
            });
    }

</script>

{{--common js functions made by me--}}
<script>
    function setInputValueByClassName(clickEventClassEle, targetClassEle, targetAttr) {
        $('.'+targetClassEle).val(clickEventClassEle.attr(targetAttr));
    }
    function equalizeHeights(className) {
        // Ensure className starts with dot for jQuery selector
        if (!className.startsWith('.')) {
            className = '.' + className;
        }

        const elements = $(className);

        // Return early if no elements found
        if (elements.length === 0) {
            console.warn(`No elements found with class: ${className}`);
            return;
        }

        // Reset heights to auto to get natural heights
        elements.css('height', 'auto');

        // Find the maximum height
        let maxHeight = 0;
        elements.each(function() {
            const currentHeight = $(this).outerHeight();
            if (currentHeight > maxHeight) {
                maxHeight = currentHeight;
            }
        });

        // Set all elements to the maximum height
        elements.css('height', maxHeight + 'px');

    }
</script>
{{--drawer mobile menu scripts--}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openDrawerBtn = document.getElementById('openDrawer');
        const closeDrawerBtn = document.getElementById('closeDrawer');
        const drawer = document.getElementById('sideDrawer');
        const overlay = document.getElementById('drawerOverlay');

        // Open drawer
        if (openDrawerBtn) {
            openDrawerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                drawer.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
        }

        // Close drawer function
        function closeDrawer() {
            drawer.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Close button
        if (closeDrawerBtn) {
            closeDrawerBtn.addEventListener('click', closeDrawer);
        }

        // Overlay click
        if (overlay) {
            overlay.addEventListener('click', closeDrawer);
        }

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawer.classList.contains('show')) {
                closeDrawer();
            }
        });
    });
</script>
@yield('script')
@stack('script')
