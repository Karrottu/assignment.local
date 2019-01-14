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
        <h6 class="text-center text-md-left">Tasks</h6>
        <h3 class="text-center text-md-left">New Taks</h3>
    </div>
</header>

<form class="row content" action="task-add-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'task-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'task-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="task-name" class="form-control mb-3" placeholder="Task Title"
                    value="<?php echo get_value($formdata, 'task-name'); ?>">

<?php if (has_error($formdata, 'task-desc')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'task-desc'); ?>
                </div>
<?php endif; ?>
                <textarea name="task-desc" rows="8" cols="80" placeholder="What do you need to do?" class="form-control mb-3"><?php echo get_value($formdata, 'task-desc'); ?></textarea>

<?php if (has_error($formdata, 'task-course')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'task-course'); ?>
            </div>
<?php endif; ?>
            <div class="form-group row">
                <label for="input-task-course" class="col-sm-3 col-form-label">Subject:</label>
                <div class="col-sm-9">
                    <select class="custom-select mb-3" name="task-course" id="input-task-course">
                        <option disabled selected>Choose a Subject</option>
<?php while ($course_row = mysqli_fetch_assoc($course)): ?>
                        <option value="<?php echo $course_row['course_id']; ?>" <?php echo ($course_row['course_id'] == $course_id) ? 'selected' : '' ?>><?php echo $course_row['crsname']; ?></option>
<?php endwhile; ?>
                    </select>
                </div>
            </div>

<?php if (has_error($formdata, 'task-deadline')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'task-deadline'); ?>
            </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-task-deadline" class="col-sm-3 col-form-label">Deadline:</label>
                    <div class="col-sm-9">
                        <input type="text" name="task-deadline" class="form-control mb-3" placeholder="DD-MM-YYYY"
                            id="input-task-deadline" value="<?php echo get_value($formdata, 'task-deadline'); ?>">
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
