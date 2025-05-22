$(function () {

    $('.select2').select2();

    $('#property_inspector_id').on('change', function () {

        let property_inspector_id = $(this).val();

        if (property_inspector_id) {
            $.ajax({
                url: '/get-property-inspector',
                type: 'GET',
                data: {
                    property_inspector_id: property_inspector_id
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    $('.callout').attr('hidden', true);
                    $('.new-property-inspector').attr('hidden', false);

                    $('.img-property-inspector').html(`
                        <img class="profile-user-img img-fluid img-circle "
                        src="/storage/profile_images/${data.user.photo}"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    `);

                    $('.profile-username').html(`
                        ${data.user.firstname} ${data.user.lastname}   
                    `);

                    $('.user-type').html(`
                        ${data.user.user_type.name}
                    `);

                    $('.employment-status').html(`
                        ${data.user.account_level.name}
                    `);

                    $('.property-inspector-postcodes').empty();

                    data.property_inspector_postcodes.forEach(postcode => {

                        $('.property-inspector-postcodes').append(`
                            <span class="badge badge-info">${postcode.outward_postcode.name}</span>
                        `);
                    });

                    $('.email').html(`
                        ${data.user.email}
                    `);

                    $('.contact-number').html(`
                        ${data.user.mobile}
                    `);

                    $('.address').html(`
                        ${data.address1} ${data.city} ${data.county} ${data.postcode}
                    `);
                }
            });
        }
    });

});