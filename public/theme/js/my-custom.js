

function loadingStart(title = null) {
    return new swal({
        title: title ? title : 'Loading',
        allowEscapeKey: false,
        allowOutsideClick: false,
        onOpen: () => {
            swal.showLoading()
        }
    });
}
function loadingStop() {
    swal.close()
}
function showSuccess(title) {
    toastr.success(title);
}

function showWarn(title) {
    toastr.error(title);
}
function deleteRecordAjax(url) {

    return new swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value == true) {
            $.ajax({
                type: 'DELETE',
                url: url,
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    showSuccess('Record Deleted Successfully.');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function (error) {
                    let message = 'Network error';
                    if (error.responseJSON) {
                        message = error.responseJSON.message
                    }
                    showWarn(message)
                }
            });
        }
    });
}

function addFormData(e, method, url, redirectUrl, data) {
    loadingStart()

    let from = document.getElementById(data);
    let record = new FormData(from)
    // if ($('.note-editable').html() != '') {
    //     record.append('descriptions', $('.note-editable').html())
    // }
    e.preventDefault()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: method,
        url: url,
        data: record,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            loadingStop()
            $(':input', data)
            .not(':button, :submit, :reset, :hidden')
            .val('')
                if ($('.upload-zone')[0] != undefined) {
                    $('.upload-zone')[0].dropzone.removeAllFiles(true)
                }
            if(response.status != false){
                showSuccess(response.message,'success')
                
                setTimeout(function () {
                    window.location = redirectUrl;
                }, 1000);
            } else {
                showWarn(response.message,'error');
            }
           
        },
        error: function (xhr) {
            loadingStop()
            console.log((xhr.responseJSON.errors));
            let data = '';
            $.each(xhr.responseJSON.errors, function (key, value) {
                data += '</br>' + value
            })
            showWarn(data)

        }
    });

}
function getCities(e, url) {
    let state_id=e.target.value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: "post",
        data: {
            state_id: state_id,
        },
        success: function (response) {
            $("#cityDetail").html();
            $("#cityDetail").html(response);
        },
    });
}