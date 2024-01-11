function deleteData(action) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Your data will be lost!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
        confirmButtonAriaLabel: 'Thumbs up, Yes!',
        cancelButtonText: '<i class="ti-thumb-down"></i> No',
        cancelButtonAriaLabel: 'Thumbs down',
        customClass: 'animated tada',
        showClass: {
            popup: 'animate__animated animate__tada'
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form_delete').attr('action', action)
            $('#form_delete').submit()
        }
    })
}