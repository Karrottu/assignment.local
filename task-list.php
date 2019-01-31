<?php
    include 'libraries/database.php';
    include 'libraries/login-check.php';
    include 'libraries/adminaccess.php';

    $id = $_COOKIE['id'];
    // 1. Checks if user has admin access
    //if user is admin, they get access to a different menu with more options
    $role = is_admin($id);
    if ($role == 1)
    {
        include 'template/headeradmin.php';
    } else{
      include 'template/header.php';
    }

    // 2. Get the information from the database.
    // if after I set $task, the value is FALSE:
    if (!$course = get_course($_GET['id']))
    {
        exit("This task doesn't exist.");
    }

    // 3. Get the tasks for this course.
    $task = get_all_tasks($_GET['id']);
    $students = get_student_list($_GET['id']);
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Course-Details</h6>
        <h3 class="text-center text-md-left"><?php echo $course['course-name']; ?></h3>
    </div>
</header>

<div class="row content">
    <div class="col-12 col-lg-9">

        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="float-right">
                    <a href="task-add.php?course=<?php echo $id; ?>">New Task</a>
                </div>
                <h6 class="m-0"><?php echo $course['course-name']; ?> Tasks</h6>
            </div>

            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Deadline</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($task)): ?>
                        <tr>
                            <td><span class="counter"></span></td>
                            <td><?php echo $row['tskname']; ?></td>
                            <td><?php echo gmdate("d/m/Y", $row['deadline']); ?></td>
                            <td>
                                <a href="task-edit.php?id=<?php echo $row['task_id']; ?>&amp;course=<?php echo $id; ?>">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="task-delete.php?id=<?php echo $row['task_id']; ?>&amp;course=<?php echo $id; ?>">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                            </td>
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
              <h6 class="m-0">Students in <?php echo $course['course-name']; ?></h6>
          </div>

          <div class="card-body p-0 text-center">
              <table class="table mb-0">
                  <thead class="bg-light">
                      <tr>
                          <th scope="col">Name</th>
                          <th scope="col">Surname</th>
                          <th scope="col">Email</th>
                      </tr>
                  </thead>
                  <tbody>
<?php while($row = mysqli_fetch_assoc($students)): ?>
                      <tr>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['surname']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                      </tr>
<?php endwhile; ?>
                  </tbody>
              </table>
          </div>
        </div>
    </div>
</div>


<?php include 'template/footer.php'; ?>
