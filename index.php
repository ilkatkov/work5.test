<?php

include_once "engine/user.php";
include_once "templates/header.php";

?>

<form action="profile/" method="POST">
    <h1>Work5</h1>
    <h2>Авторизация</h2>
    <div>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
    </div>
    <div>
        <label for="email">Пароль:</label>
        <input type="password" name="password" id="password">
    </div>
    <div>
        <input type="submit" value="Войти">
    </div>

</form>

<?php

include_once "templates/footer.php";

?>