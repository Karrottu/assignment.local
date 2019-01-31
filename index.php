<?php
    include 'libraries/database.php';
    include 'libraries/form.php';
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

    $deadline = get_all_task_deadlines($id);
    $formdata = get_formdata();
    $posts = get_all_posts();

?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Section</h6>
        <h3 class="text-center text-md-left">Page Title</h3>
    </div>
</header>

<div class="row content">
    <div class="col-12 col-lg-9">

        <div class="card">
            <div class="card-body p-0">
              <div class="card-body p-0">
                  <form class="row content" action="newsfeed-add-process.php" method="post">
                      <div class="card gedf-card ml-3 col-6">
                          <div class="card-body">
                              <div class="tab-content" id="myTabContent">
                                  <div class="form-group">
                  <?php if (has_error($formdata, 'post-body')): ?>
                                      <div class="alert-danger mb-3 p-3">
                                          <?php echo get_error($formdata, 'post-body'); ?>
                                      </div>
                  <?php endif; ?>
                                      <textarea name="post-body" rows="2" cols="120" placeholder="Write your note here" class="form-control mb-3"><?php echo get_value($formdata, 'post-body'); ?></textarea>
                                  </div>
                              </div>
                              <div class="btn-toolbar justify-content-between">
                                  <div class="btn-group">
                                      <button type="submit" class="btn btn-primary">Share</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
                  <?php
                  while ($row = mysqli_fetch_assoc($posts)):
                  $post_time = intdiv((time() - $row['time']), 60);
                  ?>
                      <div class="card gedf-card">
                          <div class="card-header">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="d-flex justify-content-between align-items-center">
                                      <div class="mr-2">
                                          <img class="rounded-circle" width="35" img src="icon.png" alt="">
                                      </div>
                                      <div class="ml-2">
                                          <div class="h5 m-0"><?php echo $row['name'];?> <?php echo $row['surname']; ?></div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                          <div class="card-body">
                              <div class="text-muted h7 mb-2"> <i class="far fa-clock"></i> <?php echo $post_time;?> minutes ago</div>
                              <p class="card-text">
                                  <?php echo $row['post_content']; ?>
                              </p>
                          </div>
                          <div class="card-footer">
                              <a href="#" class="card-link"><i class="far fa-thumbs-up"></i> Like</a>
                              <a href="#" class="card-link"><i class="far fa-comment"></i> Comment</a>
                          </div>
                      </div>
                  <?php endwhile; ?>
              </div>
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
                        <td><?php echo gmdate("d/m/Y", $row['deadline']);?></td>
                    </tr>
<?php endwhile; ?>
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

<?php
    include 'template/footer.php';
?>
