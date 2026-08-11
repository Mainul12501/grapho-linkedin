// View Job in modal
$(document).on('click', '.view-job', function () {
    event.preventDefault();
    var jobId = $(this).attr('data-job-id');
    $.ajax({
        url: "/get-job-details/" + jobId + "?render=1",
        method: "GET",
        success: function (response) {
            console.log(response);
            $('#jobDetailsBody').empty().append(response);
            $('#jobModal').modal('show');
        }
    })
})

// Infinite scroll pagination
let page = 1;
let loading = false;

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
        if (!loading) {
            loading = true;
            page++;

            $('#loader').show();

            $.get('?page=' + page, function (data) {
                if (data.trim().length === 0) {
                    $('#loader').hide();
                    return;
                }

                $('#job-container').append(data);
                loading = false;
                $('#loader').hide();
            });
        }
    }
});
