function showJobDetails(jobId, jobTitle = 'View Job Title') {
    sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
        $('#viewJobModalTitle').empty().append(jobTitle);
        $('#viewJobModalBody').empty().append(response);
        $('#viewJobModal').modal('show');
    })
}
function showPostDetails(postId, postTitle = 'View Post Title') {
    sendAjaxRequest('employee-view-post/'+postId+'?render=1', 'GET').then(function (response) {
        $('#viewPostModalTitle').empty().append(postTitle);
        $('#viewPostModalBody').empty().append(response);
        $('.zoom-img').mBox();
        $('#viewPostModal').modal('show');
    })
}

$(document).on('click', '.ed-post-click', function(e) {
    e.preventDefault();
    var postId = $(this).data('post-id');
    var postTitle = $(this).data('post-title') || 'View Post';
    showPostDetails(postId, postTitle);
});

let page = 1;
let loading = false;


function loadMoreData() {
    if (loading || page >= lastPage) return;

    loading = true;
    page++;
    $("#loader").show();

    $.ajax({
        url: "?page=" + page,
        type: "GET",
        success: function(res) {
            if ($.trim(res) === "") {
                $("#no-more-data").show();
                return;
            }

            $("#item-container").append(res);
        },
        complete: function() {
            loading = false;
            $("#loader").hide();
        }
    });
}

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
        loadMoreData();
    }
});
