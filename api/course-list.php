<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    $headers = getallheaders();

    $id         = isset($headers['User-Ref']) ? $headers['User-Ref'] : '';

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    // Gets the courses from the database, and displays them in a format the app will understand
    $courses = get_all_courses($id);
    success('course', mysqli_fetch_all($courses, MYSQLI_ASSOC));
?>
