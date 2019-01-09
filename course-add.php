<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    include 'template/header.php';

	// we can use a function to make this part easy.
    $formdata = get_formdata();
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">course</h6>
        <h3 class="text-center text-md-left">New course</h3>
    </div>
</header>

<form class="row content" action="course-add-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'course-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'course-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="course-name" class="form-control mb-3" placeholder="Course Name"
                    value="<?php echo get_value($formdata, 'course-name'); ?>">

                <div class="form-group row">
                    <label for="input-course-code" class="col-sm-3 col-form-label">Code:</label>
                    <div class="col-sm-9">
                        <input type="text" name="course-code" class="form-control mb-3" placeholder="ABC-123"
                            id="input-course-code" value="<?php echo get_value($formdata, 'course-code'); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-course-room" class="col-sm-3 col-form-label">Room:</label>
                    <div class="col-sm-9">
                        <input type="text" name="course-room" class="form-control mb-3" placeholder="ABC-123"
                            id="input-course-room" value="<?php echo get_value($formdata, 'course-room'); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-course-lecturer" class="col-sm-3 col-form-label">Lecturer:</label>
                    <div class="col-sm-9">
                        <input type="text" name="course-lecturer" class="form-control mb-3" placeholder="0"
                            id="input-course-lecturer" value="<?php echo get_value($formdata, 'course-lecturer'); ?>">
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
