
{{--normal select2 assets--}}
{{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $('.select2').select2({--}}
{{--            width: '100%',--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}




{{--bootstrap 5 select2 v4.1 cdn--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
{{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2({
            // theme: "bootstrap-5",
            // dropdownParent: $(this).parent(), // Required for dropdown styling,
            "width" : "100%",
        });

        // Fix for single select focus issue
        $(document).on('select2:open', () => {
            setTimeout(() => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 0);
        });
    });
</script>



{{--bootstrap 5 select2 v4.0 cdn--}}
{{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />--}}
{{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />--}}
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>--}}
{{--<script>--}}
{{--//     $(".select2").each(function() {--}}
{{--//         var $this = $(this);--}}
{{--//         // Find the closest modal parent, or use document.body if not in a modal--}}
{{--//         var $modal = $this.closest('.modal');--}}
{{--//         var dropdownParent = $modal.length > 0 ? $modal : $(document.body);--}}
{{--// console.log(dropdownParent+'<br/>');--}}
{{--//         $this.select2({--}}
{{--//             theme: "bootstrap-5",--}}
{{--//             width: "100%",--}}
{{--//             minimumResultsForSearch: 0, // Always show search box and make it functional--}}
{{--//             dropdownParent: dropdownParent--}}
{{--//         });--}}
{{--//     });--}}
{{--    $(document).ready(function () {--}}
{{--        $('.select2').select2({--}}
{{--            theme: 'bootstrap-5',--}}
{{--            width: '100%',--}}
{{--            minimumResultsForSearch: 0, // Always show search box and make it functional--}}
{{--            // dropdownParent : $('#createJobModal'),--}}
{{--        });--}}
{{--    });--}}


{{--</script>--}}

