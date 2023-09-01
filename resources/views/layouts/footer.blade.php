<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        let searchParams = new URLSearchParams(window.location.search)
        let page = searchParams.get('page')
        $.ajax({
            url: `/api/users?page=${page}`,
            async: false,
            dataType: 'json',
            type: 'GET',
            success: function (users) {
                let tableBody = $('#user-table tbody');
                tableBody.empty();
                console.log(users.links);

                $.each(users.data, function (index, user) {
                    let row = '<tr>' +
                        '<td>' + user.name + '</td>' +
                        '<td>' + user.city + '</td>' +
                        '<td>' + user.images_count + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            },
            error: function (error) {
                console.log('Error fetching users:', error);
            }
        });

        $('#user-form').submit(function (event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: '/users/create',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('User created successfully');
                },
                error: function (error) {
                    console.log('Error creating user:', error);
                }
            });
        });
    });
</script>
</body>
</html>