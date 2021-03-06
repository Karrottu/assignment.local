<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

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

    // 3. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($note);
    }
?>
<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">notes</h6>
    </div>
</header>
<div class="col-12">
    <div class="card">
        <div class="card-body">
<?php if (has_error($formdata, 'note-name')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'note-name'); ?>
            </div>
<?php endif; ?>

            <h1><?php echo get_value($formdata, 'note-name') ?></h1>

<?php if (has_error($formdata, 'note-body')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'note-body'); ?>
            </div>
<?php endif; ?>
            <p><?php echo get_value($formdata, 'note-body'); ?></p>
      </div>
  </div>
</div>


<?php include 'template/footer.php'; ?>
