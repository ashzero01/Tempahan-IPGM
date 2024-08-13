<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <h1>Add New Admin</h1>
    <form method="POST" action="{{ route('addadmin') }}">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="ICnumber">IC Number:</label>
            <input type="text" id="ICnumber" name="ICnumber" required>
        </div>
        <div>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>
        </div>
        <div>
            <label for="affiliation">Affiliation:</label>
            <input type="text" id="affiliation" name="affiliation" required>
        </div>
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit">Add Admin</button>
    </form>
</body>
</html>
