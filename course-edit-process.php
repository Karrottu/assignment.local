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
    $crsname    = $_POST['course-name'];
    $id         = $_POST['course-id'];
    $code       = $_POST['course-code'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($crsname))
    {
    	$has_errors = set_error('course-name', 'The name field is required.');
    }

	// 5. if there are errors, we should go back and course them.
    if ($has_errors)
    {
        redirect('course-edit', ['id' => $id]);
    }

    // 6. Check that the record exists, and try to edit it.
    $check = edit_course($id, $crsname, $code);
    if (!$check)
    {
        exit('The record could not be updated!');
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('course-list');
?>
