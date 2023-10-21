<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $data['title'] }}</title>
</head>

<body>

    <table>
        <tr>
            <th>Name</th>
            <th>{{ $data['name'] }}</th>
        </tr>

        <tr>
            <th>Email</th>
            <th>{{ $data['email'] }}</th>
        </tr>
    </table>
    <p><b>Note:- </b>you can use your old password</p>
    <a href="{{ $data['url'] }}"> Click here to login</a>
    <p>Thank you</p>
</body>

</html>
