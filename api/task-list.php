<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';

    // Gets the courses from the database, and displays them in a format the app will understand
    $tasks = get_all_tasks($course_id);
    success('task', mysqli_fetch_all($tasks, MYSQLI_ASSOC));
?>
