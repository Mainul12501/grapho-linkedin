// Delete saved job with SweetAlert
$(document).on('click', '.closeIcon', function () {
    var jobId = $(this).attr('data-job-id');
    Swal.fire({
        title: "{{ trans('common.are_you_sure') }}",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "{{ trans('common.yes') }}, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            sendAjaxRequest('employee/delete-saved-job/'+jobId, 'GET').then(function (response) {
                if (response.status == 'success') {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Success!"
                    }).then((res) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        }
    });
})

// Easy Apply Modal trigger
$(document).on('click', '.show-apply-model', function () {
    event.preventDefault();
    var applyModal = $('#easyApplyModal');
    var jobId = $(this).attr('data-job-id');
    var companyLogo = $(this).attr('data-job-company-logo');
    var applyFormUrl = base_url + 'employee/apply-job/' + jobId;
    $('.company-image').attr('src', companyLogo);
    $('#applyShareForm').attr('action', applyFormUrl);
    applyModal.css({
        display: "flex"
    });
})

// show job details on modal
function showJobDetails(jobId, jobTitle = 'View Job Title') {
    sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
        $('#viewJobModalTitle').empty().append(jobTitle);
        $('#viewJobModalBody').empty().append(response);
        $('#viewJobModal').modal('show');
    })
}
