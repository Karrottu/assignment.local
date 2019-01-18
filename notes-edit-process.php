<?php
    // This file will be used to process the add shows form.
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
    $title      = $_POST['note-name'];
    $body       = $_POST['note-body'];
    $course_id  = $_POST['note-course'] ?: NULL;
    $note_id    = $_POST['note-id'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($title))
    {
    	 $has_errors = set_error('note-name', 'The title field is required.');
    }

    if (empty($course_id))
    {
        $has_errors = set_error('note-course', 'Please choose a course.');
    }
    
	  // 5. if there are errors, we should go back and course them.
    if ($has_errors)
    {
        redirect('notes-edit', ['id' => $note_id]);
    }

    // 6. Insert the data in the table.
    // since the function will return a number, we can check it
    // to see if the query worked.
    $check = edit_note($note_id, $title, $body, $course_id);

    if (!$check)
    {
        exit("The record could not be updated!");
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('notes-list', ['id' => $note_id]);

?>
