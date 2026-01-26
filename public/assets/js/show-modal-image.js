    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.survey-photo-thumb', function () {
            var fullSrc = $(this).data('full');
            $('#surveyPhotoModalImage').attr('src', fullSrc);
            $('#surveyPhotoModal').modal('show');
        });

        $('#surveyPhotoModal').on('hidden.bs.modal', function () {
            $('#surveyPhotoModalImage').attr('src', '');
        });
    });