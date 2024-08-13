<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Users List</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>IC Number</th>
                <th>Phone Number</th>
                <th>Affiliation</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->ICnumber }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->affiliation }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('showprofile', ['user_id' => $user->id]) }}">View Profile</a>
                </td>
                <td>
                    <form method="POST" action="{{ route('users.delete', ['user_id' => $user->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>