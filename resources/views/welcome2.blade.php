<html>
<body>
<h1>

    <ul>
        @foreach($users as $user)
            <li> <?= $user->first_name?> </li>
        @endforeach
    </ul>
</h1>
</body>
</html>