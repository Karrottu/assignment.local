<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    ($_SERVER['REQUEST-METHOD'] ===  'GET') or error();
    check_login_auth() or error("You have no permission to be here.");

    // Gets the shows from the database, and displays them in a format the app will understand
    $shows = get_all_shows();
    success('shows', mysqli_fetch_all($shows, MYSQLI_ASSOC));
?>
