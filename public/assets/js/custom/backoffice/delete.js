function delete(id) {
    Swal.fire({
        text: "{{ __('site.confirmMultiDeleteMessage') }}" + "؟",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        confirmButtonText: "{{ __('site.confirmButtonText') }}",
        cancelButtonText: "{{ __('site.cancelButtonText') }}",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        },
    }).then(function(result) {
        const destroyRoute = projectBaseUrl+'/operation/remove-team-rank-item';

        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: destroyRoute,
            data: {
                '_method': 'delete',
                'id': id,
            },
            success: function(response, textStatus, xhr) {
                if (result.value) {
                    Swal.fire({
                        text: "{{ __('site.deletingselecteditem') }}",
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        Swal.fire({
                            text: response['msg'], // respose from controller
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }

                        }).then(function() {
                            // delete row data from server and re-draw datatable
                            dt.draw();
                        });

                        location.reload();
                        // Remove header checked box

                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "{{ __('site.notdeletedMessage') }}",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",

                        }
                    });
                } // end of cancel case
            }
        });
    });
}