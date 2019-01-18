<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';
    include 'libraries/adminaccess.php';

    $id = $_COOKIE['id'];
    // Checks if user has admin access
    //if user is admin, they get access to a different menu with more options
    $role = is_admin($id);
    if ($role == 1)
    {
        include 'template/headeradmin.php';
    } else{
      include 'template/header.php';
    }

    // 1. Store the id for the course in a variable.
    $noteid = $_GET['id'];

    // 2. Get the information from the database.
    // if after I set $course, the value is FALSE:
    if (!$note = get_note($noteid))
    {
        exit("This note doesn't exist.");
    }

    $course = get_all_courses_dropdown();
    $course_id = (array_key_exists('course', $_GET)) ? $_GET['course'] : NULL;

    // 3. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($note);
    }

    include 'template/header.php';
?>
<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">notes</h6>
        <h3 class="text-center text-md-left">New Taks</h3>
    </div>
</header>

<form class="row content" action="notes-edit-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'note-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'note-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="note-name" class="form-control mb-3" placeholder="Note Title"
                    value="<?php echo get_value($formdata, 'note-name'); ?>">

<?php if (has_error($formdata, 'note-body')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'note-body'); ?>
                </div>
<?php endif; ?>
                <textarea name="note-body" rows="8" cols="80" placeholder="What do you want to write?" class="form-control mb-3"><?php echo get_value($formdata, 'note-body'); ?></textarea>

<?php if (has_error($formdata, 'note-course')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'note-course'); ?>
            </div>
<?php endif; ?>
            <div class="form-group row">
                <label for="input-note-course" class="col-sm-3 col-form-label">Subject:</label>
                <div class="col-sm-9">
                    <select class="custom-select mb-3" name="note-course" id="input-note-course">
                        <option disabled selected>Choose a Subject</option>
<?php while ($course_row = mysqli_fetch_assoc($course)): ?>
                        <option value="<?php echo $course_row['course_id']; ?>" <?php echo ($course_row['course_id'] == $course_id) ? 'selected' : '' ?>><?php echo $course_row['crsname']; ?></option>

<?php endwhile; ?>
                    </select>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="note-id" value="<?php echo $id; ?>">

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>


<?php include 'template/footer.php'; ?>
