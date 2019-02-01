<?php
    include '../libraries/database.php';
    include '../libraries/http.php';

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    $noteid = isset($_GET['note_id']) ? $_GET['note_id'] : '';

    // Gets the courses from the database, and displays them in a format the app will understand
    $note = get_single_note($noteid);
    success('note', mysqli_fetch_all($note, MYSQLI_ASSOC));

?>
