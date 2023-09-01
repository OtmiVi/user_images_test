<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        let searchParams = new URLSearchParams(window.location.search)
        let page = searchParams.get('page')
        loadUsers(page)

        $('#user-form').submit(function (event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);

            $.ajax({
                url: '/api/users',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let info = '<div class="alert alert-success" role="alert">' +
                        response.message +
                        '</div>';
                    $('#info').html(info);
                },
                error: function (error) {
                    let info = '<div class="alert alert-danger" role="alert">' +
                        JSON.parse(error.responseText).message +
                        '</div>'
                    $('#info').html(info);
                }
            });
        });
    });

    function loadUsers(page) {
        $.ajax({
            url: `/api/users?page=${page}`,
            async: false,
            dataType: 'json',
            type: 'GET',
            success: function (users) {
                let tableBody = $('#user-table tbody');
                tableBody.empty();

                $.each(users.data.data, function (index, user) {
                    let row = '<tr>' +
                        '<td>' + user.name + '</td>' +
                        '<td>' + user.city + '</td>' +
                        '<td>' + user.images_count + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
                let paginationHtml = '';
                for (let i = 1; i <= users.data.last_page; i++) {
                    paginationHtml += '<button class="btn btn-secondary m-1">' +
                        '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>' +
                        '</button>';
                }
                $('#pagination').html(paginationHtml);

                $('.page-link').on('click', function (e) {
                    e.preventDefault();
                    let page = $(this).data('page');
                    loadUsers(page);
                });
            },
            error: function (error) {
                let info = '<div class="alert alert-danger" role="alert">' +
                    JSON.parse(error.responseText).message +
                    '</div>'
                $('#info').html(info);
            }
        })
    }
</script>
</body>
</html>