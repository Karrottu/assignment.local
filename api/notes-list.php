<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    $headers = getallheaders();

    $id      = 1;

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    // Gets the courses from the database, and displays them in a format the app will understand
    $notes = get_all_notes($id);
    success('note', mysqli_fetch_all($notes, MYSQLI_ASSOC));
?>
