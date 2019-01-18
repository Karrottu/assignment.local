<?php
  $id = $_COOKIE['id'];

  $role = is_admin($id);
  if ($role == 2)
  {
      exit('You have no access to this page.');
  }
?>
