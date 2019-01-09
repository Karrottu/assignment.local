<?php
    // This file will be used to process the add course form.
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
    $name       = $_POST['course-name'];
    $desc       = $_POST['course-desc'];
    $airtime    = $_POST['course-airtime'];
    $duration   = $_POST['course-duration'];
    $rating     = $_POST['course-rating'];
    $id         = $_POST['course-id'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($name))
    {
    	$has_errors = set_error('course-name', 'The name field is required.');
    }

    if (empty($airtime))
    {
    	$has_errors = set_error('course-airtime', 'The airtime field is required.');
    }

    // to confirm a time, we can use STRTOTIME.
    $airtime = strtotime($airtime, 0);

    // If the air time was not converted properly.
    if (!$airtime)
    {
    	$has_errors = set_error('course-airtime', 'The airtime is in a wrong format. Please use 00:00.');
    }

    if (empty($duration))
    {
    	$has_errors = set_error('course-duration', 'The duration field is required.');
    }

    if ($duration < 5)
    {
    	$has_errors = set_error('course-duration', 'The duration of a course should be at least 5 minutes.');
    }

    if (!empty($rating) && ($rating < 0 || $rating > 10))
    {
    	$has_errors = set_error('course-rating', 'Ratings must be between 0 and 10.');
    }

	// 5. if there are errors, we should go back and course them.
    if ($has_errors)
    {
        redirect('course-edit', ['id' => $id]);
    }

    // 6. Check that the record exists, and try to edit it.
    $check = edit_course($id, $name, $desc, $airtime, $duration, $rating);
    if (!$check)
    {
        exit('The record could not be updated!');
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('course-list');
?>
