<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';
    include 'libraries/adminaccess.php';

    // 1. Store the id for the course in a variable.
    $id = $_COOKIE['id'];

    // 2. Get the information from the database.
    // if after I set $course, the value is FALSE:
    if (!$course = get_course($_GET['id']))
    {
        exit("This course doesn't exist.");
    }

    // 3. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($course);
    }

    $role = is_admin($id);
    if ($role == 1)
    {
        include 'template/headeradmin.php';
    } else{
      include 'template/header.php';
    }
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
                <input type="text" name="course-name" class="form-control mb-3" placeholder="New course name"
                    value="<?php echo get_value($formdata, 'course-name'); ?>">
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="course-id" value="<?php echo $id; ?>">
                <input type="hidden" name="course-code" value="<?php echo get_value($formdata, 'course-code'); ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php include 'template/footer.php'; ?>
