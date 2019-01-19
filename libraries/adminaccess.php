<?php
  // This checks if the user has admin access.
  // If the user does not have admin access, access to the page is denied
  // Add this function to pages that you do not want non admin users to access.
  $id = $_COOKIE['id'];

  $role = is_admin($id);
  if ($role == 2)
  {
      exit('You have no access to this page.');
  }
?>
