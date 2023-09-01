@include('layouts.header')
<div class="container mt-5">
    <form id="user-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="city">
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>

    <table class="table mt-4" id="user-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>City</th>
            <th>Count</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="pagination"></div>
</div>
@include('layouts.footer')
