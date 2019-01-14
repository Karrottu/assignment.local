<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    include 'template/header.php';

    $course = get_all_courses_dropdown();
    $course_id = (array_key_exists('course_id', $_GET)) ? $_GET['course_id'] : NULL;

	// we can use a function to make this part easy.
    $formdata = get_formdata();
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Notes</h6>
        <h3 class="text-center text-md-left">New Note</h3>
    </div>
</header>

<form class="row content" action="notes-add-process.php" method="post">
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
                <textarea name="note-body" rows="8" cols="80" placeholder="Write your note here" class="form-control mb-3"><?php echo get_value($formdata, 'note-body'); ?></textarea>

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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php include 'template/footer.php'; ?>
