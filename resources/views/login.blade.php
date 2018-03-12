<html>
<h1>

    <ul>
        @foreach($users as $user)
            <li> <?= $user->first_name?> </li>
        @endforeach
    </ul>
</h1>

<h2>Create New User</h2>
<form name=createNewUser method="post" action="../createNewUser.php" >
    <div>
        <label class=field for="f_name"><span class="required">*</span>First name</label>
        <input id="f_name" name="f_name" required="" type="text" autofocus>
    </div>
    <br>
    <div>
        <label class=field for="l_name"><span class="required">*</span>Last name</label>
        <input id="l_name" name="l_name" required="" type="text">
    </div>
    <br>
    <div>
        <label class=field for="email"><span class="required">*</span>Email</label>
        <input id="email" name="email" required="" type="email">
    </div>
    <input type="submit" value="Create New User !">
    <input type="reset" value="Reset form">
</form>


</html>