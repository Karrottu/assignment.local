<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    // Gets the shows from the database, and displays them in a format the app will understand
    $courses = get_all_courses();
    success('course', mysqli_fetch_all($courses, MYSQLI_ASSOC));
?>
