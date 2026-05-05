

toastr.options.onShown = function() {
    $('.toast').css('opacity', '1');
};

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

            $(this).parent().submit();
        }

    })
})

function sendAjaxRequest(url, method, data = {}) {
    return $.ajax({ // Return the Promise from $.ajax
        url: base_url + url,
        method: method,
        data: data
    })
        .done(function (data) { // .done() for success

        })
        .fail(function (error) { // .fail() for error
            toastr.error(error);
            // The error will also be propagated to the .catch() when called
        });
}

// employee drawer mobile menu scripts
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
