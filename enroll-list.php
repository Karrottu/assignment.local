<?php
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    include 'template/header.php';

    $id = $_COOKIE['id'];
    $course = get_all_enrolled_courses($id);
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">course</h6>
        <h3 class="text-center text-md-left">All Courses</h3>
    </div>
</header>

<div class="row content">
    <div class="col">

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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($course)): ?>
                        <tr>
                            <td><?php echo $row['code']; ?></td>
                            <td><?php echo $row['crsname']; ?></td>
                            <td>
                                <a href="course-edit.php?id=<?php echo $row['course_id']; ?>">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="course-delete.php?id=<?php echo $row['course_id']; ?>">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                                <a href="task-list.php?id=<?php echo $row['course_id']; ?>">
                                    <i class="icon fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>

<?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<?php include 'template/footer.php'; ?>
