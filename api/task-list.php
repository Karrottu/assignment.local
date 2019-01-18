<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    $headers = getallheaders();

    $course_id = isset($data['course_id']) ? $data['course_id'] : '';

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    // Gets the courses from the database, and displays them in a format the app will understand
    $tasks = get_all_tasks($course_id);
    success('task', mysqli_fetch_all($tasks, MYSQLI_ASSOC));
?>
