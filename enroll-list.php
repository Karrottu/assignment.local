<?php
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    $id = $_COOKIE['id'];
    $role = is_admin($id);
    if ($role == 1)
    {
        include 'template/headeradmin.php';
    } else{
      include 'template/header.php';
    }
    $course = get_all_enrolled_courses($id);
    $deadline = get_all_task_deadlines($id);
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">course-list</h6>
        <h3 class="text-center text-md-left">All Courses</h3>
    </div>
</header>

<div class="row content">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-header border-bottom-0">
                <h6 class="m-0">Table</h6>
            </div>
            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($course)): ?>
                        <tr>
                            <td><?php echo $row['code']; ?></td>
                            <td><?php echo $row['crsname']; ?></td>
                        </tr>
<?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
          <div class="card-header border-bottom-0">
              <h6 class="m-0">Upcoming</h6>
          </div>

          <div class="card-body p-0 text-center">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th scope="col">Task Name</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Deadline</th>
                    </tr>
                </thead>
                <tbody>
<?php while($row = mysqli_fetch_assoc($deadline)): ?>
                    <tr>
                        <td><?php echo $row['tskname']; ?></td>
                        <td><?php echo $row['crsname']; ?></td>
                        <td><?php echo $row['deadline']; ?></td>
                    </tr>
<?php endwhile; ?>
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>


<?php include 'template/footer.php'; ?>
