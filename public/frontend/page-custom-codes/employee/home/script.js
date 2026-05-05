$(document).on('click', '.save-btn', function () {
    var jobId = $(this).attr('data-job-id');
    var isSaved = $(this).attr('is-saved');
    var thisBtn = $(this);
    if (isSaved == 'yes')
    {
        toastr.info('You have already saved this job.');
        return;
    }
    var thisElement = $(this);
    sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
        if (response.status == 'success')
        {
            $(this).attr('disabled', true);
            thisElement.addClass('force-hide');
            sendAjaxRequest('employee/get-total-saved-jobs', 'GET').then(function (res) {
                $('#savedJobsNumber').text(res);
            })
            $('#saveBtnImg'+jobId).attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
            $('#saveBtnTxt'+jobId).text("{{ trans('common.saved') }}");
            thisBtn.removeClass('bg-primary text-white').addClass('bg-gray-300 bg-light text-dark');
            toastr.success(response.msg);
            thisElement.closest('.eh-job-card').hide();
        }
        else if (response.status == 'error')
        {
            toastr.error(response.msg);
        }
    })
})

$(document).on('click', '.save-btnx', function () {
    var jobId = $(this).attr('data-job-id');
    var thisObject = $(this);
    sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
        if (response.status == 'success')
        {
            thisObject.attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
            sendAjaxRequest('employee/get-total-saved-jobs', 'GET').then(function (res) {
                $('#savedJobsNumber').text(res);
            })
            toastr.success(response.msg);
        }
        else if (response.status == 'error')
        {
            toastr.error(response.msg);
        }
    })
})

$(document).on('click', '.show-apply-model', function (){
    event.preventDefault();
    var applyModal = $('#easyApplyModal');
    var jobId = $(this).attr('data-job-id');
    var companyLogo = $(this).attr('data-job-company-logo');
    var applyFormUrl = base_url+'employee/apply-job/'+jobId;
    $('.company-image').attr('src', companyLogo);
    $('#applyShareForm').attr('action', applyFormUrl);
    applyModal.css({
        display: "flex"
    });
})
function showJobDetails(jobId, jobTitle = 'View Job Title') {
    sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
        $('#viewJobModalTitle').empty().append(jobTitle);
        $('#viewJobModalBody').empty().append(response);
        $('#viewJobModal').modal('show');
    })
}
