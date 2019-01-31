<?php
    include '../libraries/http.php';
    include '../libraries/database.php';

    // 1. Check if we are using a POST request.
    ($_SERVER['REQUEST_METHOD'] === 'POST' or error());

    // 2. WE canuse a custom function to read the information from the app.
    get_input_stream($data);

    $code      = isset($data['code']) ? $data['code'] : '';

    if (empty($code))
    {
    	error('Please enter a course code');
    }

    $course_id = get_course_code($code);
    $user_id = 1;

    $check = enroll_user($user_id, $course_id);
    if(!$check)
    {
        error('User not enrolled due to an error');
    }

    $courses = get_all_courses($user_id);
    success('course', mysqli_fetch_all($courses, MYSQLI_ASSOC));
?>
