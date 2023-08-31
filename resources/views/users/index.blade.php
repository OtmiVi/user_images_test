<!-- resources/views/users/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <!-- Include necessary CSS and JS files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<form id="user-form" enctype="multipart/form-data">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name"><br>
    <label for="city">City:</label>
    <input type="text" name="city"><br>
    <label for="image">Image:</label>
    <input type="file" name="image"><br>
    <button type="submit">Create User</button>
</form>

<table id="user-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>City</th>
        <th>Count</th>
    </tr>
    </thead>
    <tbody>
    <!-- User data will be populated here using AJAX -->
    </tbody>
</table>

<script>
    $(document).ready(function() {
        let searchParams = new URLSearchParams(window.location.search)
        let page = searchParams.get('page')
        $.ajax({
            url: `http://127.0.0.1:8000/api/users?page=${page}`,
            async: false,
            dataType: 'json',
            type: 'GET',
            success: function(users) {
                let tableBody = $('#user-table tbody');
                tableBody.empty();
                console.log(users.links);

                $.each(users.data, function(index, user) {
                    let row = '<tr>' +
                        '<td>' + user.name + '</td>' +
                        '<td>' + user.city + '</td>' +
                        '<td>' + user.images_count + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.log('Error fetching users:', xhr);
                console.log(xhr.responseText); // Log the detailed response
            }
        });

        // Handle form submission using AJAX
        $('#user-form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: '/users/create',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('User created successfully');
                },
                error: function(error) {
                    console.log('Error creating user:', error);
                }
            });
        });
    });
</script>
</body>
</html>
