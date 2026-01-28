    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.survey-photo-thumb', function (event) {
            event.preventDefault();
            var fullSrc = $(this).data('full') || $(this).attr('src');
            if (!fullSrc) {
                return;
            }

            if ($('#surveyPhotoModal').length) {
                $('#surveyPhotoModalImage').attr('src', fullSrc);
                $('#surveyPhotoModal').modal('show');
            } else {
                window.open(fullSrc, '_blank');
            }
        });
    });