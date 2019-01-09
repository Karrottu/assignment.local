<?php

    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. Store the id for the course in a variable.
    $id = $_GET['id'];

    // 2. Even in delete functions, we must check that the course exists.
    // In this case, you might also want to see if the user has permission
    // to delete a record.
    // if after I set $course, the value is FALSE:
    if (!$course = get_course($id))
    {
        exit("This course doesn't exist.");
    }

    if (!delete_course($id))
    {
        exit("The course could not be deleted.");
    }

    redirect('course-list');
?>
