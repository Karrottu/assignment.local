<?php
    include '../libraries/http.php';
    include '../libraries/database.php';

    // 1. Check if we are using a POST request.
    ($_SERVER['REQUEST_METHOD'] === 'POST' or error());

    // 2. WE canuse a custom function to read the information from the app.
    get_input_stream($data);

    $email      = isset($data['email']) ? $data['email'] : '';
    $password   = isset($data['password']) ? $data['password'] : '';
    $name       = isset($data['name']) ? $data['name'] : '';
    $surname    = isset($data['surname']) ? $data['surname'] : '';
    $role       = isset($data['role']) ? $data['role'] : '';

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
