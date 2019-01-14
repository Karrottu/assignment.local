<?php
    // This file will be used to process the add courses form.
    include 'libraries/form.php';

    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. check that the form has been sent.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        exit('You have no access to this page.');
    }

    // 2. store the form data in case of any errors.
	set_formdata($_POST);

    // 3. retrieve the variables from $_POST.
    $name       = $_POST['task-name'];
    $desc       = $_POST['task-desc'];
    $course_id  = $_POST['task-course'] ?: NULL;
    $deadline   = $_POST['task-deadline'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($name))
    {
    	$has_errors = set_error('task-name', 'The name field is required.');
    }

    if (empty($course_id))
    {
        $has_errors = set_error('task-course', 'Please choose a course.');
    }

    if (empty($deadline))
    {
    	$has_errors = set_error('task-deadline', 'A deadline is required.');
    }

    // to confirm a time, we can use STRTOTIME.
    $deadline = strtotime($deadline);

    // If the air time was not converted properly.
    if (!$deadline)
    {
    	$has_errors = set_error('task-deadline', 'The air date is in a wrong format. Please use DD/MM/YYYY.');
    }

	// 5. if there are errors, we should go back and course them.
    if ($has_errors)
    {
        redirect('task-add', ['course' => $course_id]);
    }


    // 6. Insert the data in the table.
    // since the function will return a number, we can check it
    // to see if the query worked.
    $check = add_task($name, $desc, $deadline, $course_id);
    if (!$check)
    {
        exit("The query was unsuccessful.");
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('task-list', ['id' => $course_id]);

?>
