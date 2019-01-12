<?php

  function isadmin($user_id)
  {
    // 1. Connect to the database.
    $link = connect();

    // 2. Retrieve all the rows from the table.
    $user_id = mysqli_query($link, "
        SELECT id
        FROM tbl_roles
    ");

    // 3. Disconnect from the database.
    disconnect($link);

    // 4. Return the result set.
    return $user_id;
  }

  function set_permission()
  {

  }

?>
