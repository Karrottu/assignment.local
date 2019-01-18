<?php

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

    //This lets the user only see the notes that are assigned to their ID
    $note = get_all_notes($id);
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Notes</h6>
        <h3 class="text-center text-md-left">All Notes</h3>
    </div>
</header>

<div class="row content">
    <div class="col">

        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="float-right">
                    <a href="notes-add.php">New Note</a>
                </div>
                <h6 class="m-0">All Notes</h6>
            </div>

            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Name</th>
                            <th scope="col">Body</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($note)):?>
                        <tr>
                            <td><span class="counter"></span></td>
                            <td><?php echo $row['crsname']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['note']; ?></td>
                            <td>
                                <a href="notes-edit.php?id=<?php echo $row['note_id']; ?>">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="notes-delete.php?id=<?php echo $row['note_id']; ?>">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                                <a href="note-view.php?id=<?php echo $row['note_id']; ?>">
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
