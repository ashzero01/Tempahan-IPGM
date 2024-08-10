<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <h1>User Profile</h1>
        <a href="{{ route('showprofile', ['user_id' => $user->id]) }}">Edit Profile</a>
        <!-- Add other navigation or header elements here -->
    </header>
    <main>
        <div class="profile-info">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
            <p><strong>Affiliation:</strong> {{ $user->affiliation }}</p>
            <p><strong>IC Number:</strong> {{ $user->ICnumber }}</p>
        </div>
    </main>
</body>
</html>
