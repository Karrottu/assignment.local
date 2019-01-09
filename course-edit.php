<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. Store the id for the course in a variable.
    $id = $_GET['id'];

    // 2. Get the information from the database.
    // if after I set $course, the value is FALSE:
    if (!$course = get_course($id))
    {
        exit("This course doesn't exist.");
    }

    // 3. modify the data we need to fit a specific format.
    $course['course-airtime'] = date('H:i', $course['course-airtime']);
    $channels = get_all_channels();

    // 4. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($course);
    }

    include 'template/header.php';
?>
<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">course</h6>
        <h3 class="text-center text-md-left">Edit course</h3>
    </div>
</header>

<form class="row content" action="course-edit-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'course-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'course-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="course-name" class="form-control mb-3" placeholder="New course"
                    value="<?php echo get_value($formdata, 'course-name'); ?>">

<?php if (has_error($formdata, 'course-desc')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'course-desc'); ?>
                </div>
<?php endif; ?>
                <textarea name="course-desc" rows="8" cols="80" placeholder="What is this course about?" class="form-control mb-3"><?php echo get_value($formdata, 'course-desc'); ?></textarea>

<?php if (has_error($formdata, 'course-channel')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'course-channel'); ?>
            </div>
<?php endif; ?>
            <div class="form-group row">
                <label for="input-course-channel" class="col-sm-3 col-form-label">Channel:</label>
                <div class="col-sm-9">
                    <select class="custom-select mb-3" name="course-channel" id="input-course-channel">
                        <option disabled selected>Choose an Channel</option>
<?php while ($channel = mysqli_fetch_assoc($channels)): ?>
                        <option value="<?php echo $channel['id']; ?>" <?php echo ($channel['id'] == get_value($formdata, 'course-channel')) ? 'selected' : '' ?>><?php echo $channel['name']; ?></option>

<?php endwhile; ?>
                    </select>
                </div>
            </div>

<?php if (has_error($formdata, 'course-airtime')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'course-airtime'); ?>
            </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-course-airtime" class="col-sm-3 col-form-label">Airtime:</label>
                    <div class="col-sm-9">
                        <input type="text" name="course-airtime" class="form-control mb-3" placeholder="00:00"
                            id="input-course-airtime" value="<?php echo get_value($formdata, 'course-airtime'); ?>">
                    </div>
                </div>

<?php if (has_error($formdata, 'course-duration')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'course-duration'); ?>
                </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-course-duration" class="col-sm-3 col-form-label">Duration (mins):</label>
                    <div class="col-sm-9">
                        <input type="number" name="course-duration" class="form-control mb-3" placeholder="0"
                            id="input-course-duration" value="<?php echo get_value($formdata, 'course-duration'); ?>">
                    </div>
                </div>

<?php if (has_error($formdata, 'course-rating')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'course-rating'); ?>
                </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-course-rating" class="col-sm-3 col-form-label">Rating:</label>
                    <div class="col-sm-9">
                        <input type="number" name="course-rating" class="form-control mb-3" placeholder="0"
                            step="0.1" id="input-course-rating" value="<?php echo get_value($formdata, 'course-rating'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="course-id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php include 'template/footer.php'; ?>
