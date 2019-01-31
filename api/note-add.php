<?php
    include '../libraries/http.php';
    include '../libraries/database.php';

    // 1. Check if we are using a POST request.
    ($_SERVER['REQUEST_METHOD'] === 'POST' or error());

    // 2. WE canuse a custom function to read the information from the app.
    get_input_stream($data);

    $title       = isset($data['title']) ? $data['title'] : '';
    $body        = isset($data['body']) ? $data['body'] : '';
    $course_id   = isset($data['course']) ? $data['course'] : '';

    if (empty($title))
    {
        error('Please enter a note title');
    }

    if (empty($course_id))
    {
        error('Please enter a course');
    }

    $user_id = 1;

    $check = add_note($title, $body, $course_id, $user_id));
    if(!$check)
    {
        error('Note could not be added due to an error');
    }

    $notes = get_all_notes($user_id);
    success('note', mysqli_fetch_all($notes, MYSQLI_ASSOC));
?>
