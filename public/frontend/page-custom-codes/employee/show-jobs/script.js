// Job card click -> load details
$(document).on('click', '.job-card-ajax', function () {
    var jobId = $(this).attr('data-job-id');
    sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
        console.log(response);
        if (window.innerWidth > 768) {
            const jobDetailsDiv = document.querySelector('.sj-detail-panel');
            if (jobDetailsDiv) {
                jobDetailsDiv.style.display = 'block';
                jobDetailsDiv.innerHTML = response;
            }
        } else {
            const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
            jobDetailsDiv.style.display = 'block';
            jobDetailsDiv.innerHTML = response;
            $('#jobDeatilsForModal').modal('show');
        }
    });
})

// Save job
$(document).on('click', '.save-btn', function () {
    var jobId = $(this).attr('data-job-id');
    var isSaved = $(this).attr('is-saved');
    if (isSaved == 'yes') {
        toastr.info(commonSaved);
        return;
    }
    var thisElement = $(this);
    sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
        if (response.status == 'success') {
            $(this).attr('disabled', true);
            thisElement.addClass('force-hide');
            $('#saveBtnImg'+jobId).attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
            $('#saveBtnTxt'+jobId).text(commonSaved);
            toastr.success(response.msg);
            location.reload();
        } else if (response.status == 'error') {
            toastr.error(response.msg);
        }
    })
})

// Easy apply modal
$(document).on('click', '.show-apply-model', function () {
    event.preventDefault();
    var applyModal = $('#easyApplyModal');
    var jobId = $(this).attr('data-job-id');
    var companyLogo = $(this).attr('data-job-company-logo');
    var applyFormUrl = base_url+'employee/apply-job/'+jobId;
    $('.company-image').attr('src', companyLogo);
    $('#applyShareForm').attr('action', applyFormUrl);
    applyModal.css({ display: "flex" });
})

// Clear all

const clearBtn = document.getElementById('clearAllBtn');
if (clearBtn) clearBtn.addEventListener('click', function () {
    window.location.href = "{{ route('employee.show-jobs') }}";
});

function resetAllDropdowns() {
    document.querySelectorAll('.custom-select').forEach(dropdownEl => {
        dropdownEl.querySelectorAll('.locationCheckbox').forEach(cb => (cb.checked = false));
        dropdownEl.querySelectorAll('input[type="hidden"][data-filter-value]').forEach(inp => inp.remove());
        const input = dropdownEl.querySelector('.locationSearch');
        const placeholderText = dropdownEl.dataset.placeholder || 'Select...';
        if (input) {
            input.value = '';
            input.placeholder = placeholderText;
            input.classList.remove('select-boxCustom');
        }
        const panel = dropdownEl.querySelector('.locationDropdown');
        if (panel) panel.style.display = 'none';
    });
    window.JOB_FILTERS = {};
    document.dispatchEvent(new CustomEvent('filters:change', { detail: {} }));
}

// Infinite scroll
let currentPage = 1;
let isLoading = false;

let observer;

$(document).ready(function() {
    initInfiniteScroll();
});

function initInfiniteScroll() {
    const sentinel = $('<div id="scroll-sentinel" style="height: 1px;"></div>');
    $('#job-list-container').append(sentinel);

    const options = {
        root: document.querySelector('#job-options-container'),
        rootMargin: '100px',
        threshold: 0
    };

    observer = new IntersectionObserver(handleIntersection, options);
    observer.observe(document.getElementById('scroll-sentinel'));
}

function handleIntersection(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting && !isLoading && hasMorePages) {
            loadMoreJobs();
        }
    });
}

function loadMoreJobs() {
    isLoading = true;
    $('#loading-indicator').show();

    const urlParams = new URLSearchParams(window.location.search);
    const params = { page: currentPage + 1 };

    if (urlParams.has('search_text')) {
        params.search_text = urlParams.get('search_text');
    }
    if (urlParams.has('filters')) {
        params.filters = urlParams.get('filters');
    }

    $.ajax({
        url: '{{ route("employee.show-jobs") }}',
        type: 'GET',
        data: params,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            if (response.html) {
                $('#scroll-sentinel').before(response.html);
                currentPage = response.next_page;
                hasMorePages = response.has_more;
                jobCounter += $(response.html).filter('.sj-job-card').length;
                $('#job-count').text(jobCounter);
                bindJobCardEvents();
                if (!hasMorePages) {
                    observer.disconnect();
                    $('#scroll-sentinel').remove();
                }
            }
            $('#loading-indicator').hide();
            isLoading = false;
        },
        error: function(xhr, status, error) {
            console.error('Error loading more jobs:', error);
            $('#loading-indicator').hide();
            isLoading = false;
        }
    });
}

function bindJobCardEvents() {
    $('.job-card-ajax').off('click').on('click', function() {
        var jobId = $(this).attr('data-job-id');
        sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
            console.log(response);
            if (window.innerWidth > 768) {
                const jobDetailsDiv = document.querySelector('.sj-detail-panel');
                if (jobDetailsDiv) {
                    jobDetailsDiv.style.display = 'block';
                    jobDetailsDiv.innerHTML = response;
                }
            } else {
                const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
                jobDetailsDiv.style.display = 'block';
                jobDetailsDiv.innerHTML = response;
                $('#jobDeatilsForModal').modal('show');
            }
        });
    });
}

function setLetSideActiveJob(jobId) {
    document.querySelectorAll('.sj-job-card').forEach(card => card.classList.remove('sj-job-active'));
    const activeCard = document.getElementById('job-' + jobId);
    if (activeCard) activeCard.classList.add('sj-job-active');
}
