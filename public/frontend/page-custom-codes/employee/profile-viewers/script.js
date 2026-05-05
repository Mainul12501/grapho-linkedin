let page = 1;
let loading = false;

$(window).on('scroll', function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {

        if (loading) return;
        loading = true;
        page++;

        $('#loader').show();

        $.get('?page=' + page, function (data) {
            if (data.trim() === '') {
                $('#loader').hide();
                return;
            }

            $('#viewer-container').append(data);
            loading = false;
            $('#loader').hide();
        });
    }
});
