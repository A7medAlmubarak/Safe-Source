<!DOCTYPE html>
<html>
<head>
    <title>History Records</title>
</head>
<body>
    <h1>History Records</h1>
    <table>
        <thead>
            <tr>
                <th>File ID</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $record)
                <tr>
                    <td>{{ $record['file_id'] }}</td> <!-- Accessing as an array -->
                    <td>{{ $record['user_id'] }}</td>
                    <td>{{ $record['status'] }}</td>
                    <td>{{ $record['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
