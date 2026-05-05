$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    nav: true,
    dots: false,
    navText: [
        '<span class="owl-prev-btn">&#10094;</span>',
        '<span class="owl-next-btn">&#10095;</span>'
    ],
    responsive:{
        0:{
            items:2,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
})

var startNumber = 0;
var endNumber = 10;
$(document).ready(function () {
    sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
        $('#appendContentHere').append(response);
        startNumber += 1;
    })
});

let loading = false;
$(window).on('scroll', function () {
    if (!loading && $(window).scrollTop() + $(window).height() >= $(document).height() - 10) {
        loading = true;
        sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
            $('#appendContentHere').append(response);
            startNumber += 10;
            loading = false;
        })
    }
});

$(document).on('click', '.follow-btn', function () {
    let companyEmployerId = $(this).attr('data-employer-id');
    let companyEmployerName = $(this).attr('data-employer-company-name');
    let postId = $(this).attr('data-post-id');
    let followHistoryStatus = $(this).attr('data-follow-history-status');
    sendAjaxRequest(`employer/set-follow-history?employer_id=${companyEmployerId}&status=${ followHistoryStatus == 1 ? 'false' : 'true' }`, 'GET').then(function (response) {
        if (response.status == 'success' )
        {
            if (response.follow_status == 1)
            {
                toastr.success(`You followed ${companyEmployerName} successfully.`);
                $('#followBtn'+postId).text("{{ trans('employer.unfollow') }}").attr('data-follow-history-status', 1);

            } else if (response.follow_status == 0)
            {
                toastr.warning(`You Unfollowed ${companyEmployerName} successfully.`);
                $('#followBtn'+postId).text("{{ trans('employer.follow') }}").attr('data-follow-history-status', 0);
            }
        } else {
            alert('Please try again.')
        }
    })
})
