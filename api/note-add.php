<?php
    include '../libraries/http.php';
    include '../libraries/database.php';

    $headers = getallheaders();

    $id      = 1;

    ($_SERVER['REQUEST_METHOD'] ===  'GET') or error();

    // Gets the courses from the database, and displays them in a format the app will understand
    $notes = get_all_notes($id);
    success('note', mysqli_fetch_all($notes, MYSQLI_ASSOC));

    // 1. Check if we are using a POST request.
    ($_SERVER['REQUEST_METHOD'] === 'POST' or error());

    // 2. WE canuse a custom function to read the information from the app.
    get_input_stream($data);

    $email      = isset($data['email']) ? $data['email'] : '';
    $password   = isset($data['password']) ? $data['password'] : '';


    // 3. check the inputs that are required.
    if (empty($email) || empty($password) || empty($name) || empty($surname))
    {
    	error('Please fill in your details');
    }

    $salt = random_code();

    $id = register_login_data($email, $password, $salt, $role);
    if(!$id)
    {
        exit('The query was unsuccessful.');
    }

    $check = register_user_details($id, $name, $surname);
    if(!$check)
    {
        exit('User not fully registered');
    }

?>
