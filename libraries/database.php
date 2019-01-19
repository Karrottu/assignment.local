<?php
    // Connects to the MySQL database.
    function connect()
    {
        // 1. Assign a new connection to a new variable.
        $link = mysqli_connect('assignment.local', 'root', '', 'db_StudentCompanion')
            or die('Could not connect to the database.');

        // 2. Give back the variable so we can always use it.
        return $link;
    }

    // Disconnects the website from the database.
    function disconnect(&$link)
    {
        mysqli_close($link);
    }

    // Add a new course to the table.
    function add_course($name, $code)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_courses
                (crsname, code)
            VALUES
                (?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ss', $name, $code);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Add a new task to the table.
    function add_task($name, $desc, $deadline, $course_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_tasks
                (tskname, description, deadline, course_id)
            VALUES
                (?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssii', $name, $desc, $deadline, $course_id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Add a new note to the table.
    function add_note($title, $body, $course_id, $user_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_notes
                (title, note, tbl_courses_id, tbl_users_id)
            VALUES
                (?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssii', $title, $body, $course_id, $user_id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Checks that the userdata is valid
    function check_api_auth($id, $auth_code)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $auth_code = mysqli_real_escape_string($link, $auth_code);
        $expiration = mysqli_real_escape_string($link, time());

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT tbl_users_id
            FROM tbl_user_auth
            WHERE
                tbl_users_id = {$id} AND
                auth_code = {$auth_code} AND
                expiration = {$expiration}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // Checks that the information in a course has changed.
    function check_course($id, $crsname, $code)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $crsname = mysqli_real_escape_string($link, $crsname);
        $code = mysqli_real_escape_string($link, $code);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT course_id
            FROM tbl_courses
            WHERE
                course_id = {$id} AND
                crsname = '{$crsname}' AND
                code = '{$code}'
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // Checks that the information in a note has changed.
    function check_note($note_id, $title, $body, $course_id)
    {
      // 1. Connect to the database.
      $link = connect();

      // 2. Protect variables to avoid any SQL injection
      $note_id = mysqli_real_escape_string($link, $note_id);
      $title = mysqli_real_escape_string($link, $title);
      $body = mysqli_real_escape_string($link, $body);
      $course_id = mysqli_real_escape_string($link, $course_id);

      // 3. Generate a query and return the result.
      $result = mysqli_query($link, "
          SELECT note_id
          FROM tbl_notes
          WHERE
              note_id = {$note_id} AND
              title = '{$title}' AND
              note = '{$body}' AND
              tbl_courses_id = {$course_id}
      ");

      // 4. Disconnect from the database.
      disconnect($link);

      // 5. There should only be one row, or FALSE if nothing.
      return mysqli_num_rows($result) == 1;
    }

    // Checks that the information in a show has changed.
    function check_task($task_id, $tskname, $desc, $deadline, $course_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $task_id = mysqli_real_escape_string($link, $task_id);
        $tskname = mysqli_real_escape_string($link, $tskname);
        $desc = mysqli_real_escape_string($link, $desc);
        $deadline = mysqli_real_escape_string($link, $deadline);
        $course_id = mysqli_real_escape_string($link, $course_id);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT task_id
            FROM tbl_tasks
            WHERE
                task_id = {$task_id} AND
                tskname = '{$tskname}' AND
                description = '{$desc}' AND
                deadline = '{$deadline}' AND
                course_id = {$course_id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // verifies the password according to the email generated.
    function check_password($email, $password)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $email = mysqli_real_escape_string($link, $email);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT id, password, salt
            FROM tbl_users
            WHERE email = '{$email}'
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. If no record exists, we can stop here.
        if (!$record =  mysqli_fetch_assoc($result))
        {
            return FALSE;
        }
        // 6. We can check that the password matches what is on record.
        $password = $record['salt'].$password;
        if(!password_verify($password, $record['password']))
        {
            return FALSE;
        }
        // 7. all is fine
        return $record ['id'];
    }

    // Clears the login data from a table.
    function clear_login_data($id, $auth_code)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            DELETE FROM tbl_user_auth
            WHERE tbl_users_id = ? AND auth_code = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer
        mysqli_stmt_bind_param($stmt, 'is', $id, $auth);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Deletes a course from the table.
    function delete_course($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            DELETE FROM tbl_courses
            WHERE course_id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Deletes a note from the table
    function delete_note($id)
    {
      // 1. Connect to the database.
      $link = connect();

      // 2. Prepare the statement using mysqli
      // to take care of any potential SQL injections.
      $stmt = mysqli_prepare($link, "
          DELETE FROM tbl_notes
          WHERE note_id = ?
      ");

      // 3. Bind the parameters so we don't have to do the work ourselves.
      // the sequence means: integer
      mysqli_stmt_bind_param($stmt, 'i', $id);

      // 4. Execute the statement.
      mysqli_stmt_execute($stmt);

      // 5. Disconnect from the database.
      disconnect($link);

      // 6. If the query worked, we should have changed one row.
      return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Deletes a task from the table.
    function delete_task($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            DELETE FROM tbl_tasks
            WHERE task_id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Edit a course in the table.
    function edit_course($id, $crsname, $code)
    {
        if (check_course($id, $crsname, $code))
        {
            return TRUE;
        }

        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            UPDATE tbl_courses
            SET
                crsname = ?,
                code = ?
            WHERE
                course_id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        mysqli_stmt_bind_param($stmt, 'ssi', $crsname, $code, $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);


        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Edit a note in the table.
    function edit_note($note_id, $title, $body, $course_id)
    {
      if (check_note($note_id, $title, $body, $course_id))
      {
        return TRUE;
      }
      // 1. Connect to the database.
      $link = connect();

      // 2. Prepare the statement using mysqli
      // to take care of any potential SQL injections.
      $stmt = mysqli_prepare($link, "
          UPDATE tbl_notes
          SET
              title = ?,
              note = ?,
              tbl_courses_id = ?
          WHERE
              note_id = ?
      ");

      // 3. Bind the parameters so we don't have to do the work ourselves.
      // the sequence means: string string double integer double integer
      mysqli_stmt_bind_param($stmt, 'ssii', $title, $body, $course_id, $user_id);

      // 4. Execute the statement.
      mysqli_stmt_execute($stmt);

      // 5. Disconnect from the database.
      disconnect($link);

      // 6. If the query worked, we should have changed one row.
      return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Edit a task in the table.
    function edit_task($task_id, $tskname, $desc, $deadline, $course_id)
    {
        if (check_task($task_id, $tskname, $desc, $deadline, $course_id))
        {
            return TRUE;
        }

        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            UPDATE tbl_tasks
            SET
                tskname = ?,
                description = ?,
                deadline = ?,
                course_id = ?
            WHERE
                task_id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double integer
        mysqli_stmt_bind_param($stmt, 'ssiii', $tskname, $desc, $deadline, $course_id, $task_id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Checks if an email is already registered.
    function email_exists($email)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $email = mysqli_real_escape_string($link, $email);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT id
            FROM tbl_users
            WHERE email = '{$email}'
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) >= 1;
    }

    // Enrolls users in courses, and tracks which student is in which course
    function enroll_user($user_id, $course_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_enrollment
                (tbl_users_id, tbl_course_id)
            VALUES
                (?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $course_id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_affected_rows($stmt);
    }

    // Retrieves all the courses available in the database.
    function get_all_courses($id)
    {
        // 1. Connect to the database.
        $link = connect();

        $id = mysqli_real_escape_string($link, $id);

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT
                a. course_id,
                a. crsname,
                a. code
            FROM
                tbl_courses a
            LEFT JOIN
                tbl_enrollment b
            ON
                a.course_id = b.tbl_course_id
            WHERE
                tbl_users_id = {$id}
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves all the courses that a particular user has enrolled in
    function get_all_enrolled_courses($id)
    {
      // 1. Connect to the database.
      $link = connect();

      // 2. Retrieve all the rows from the table.
      $result = mysqli_query($link, "
          SELECT
              b. crsname,
              b. code
          FROM
              tbl_enrollment a
          LEFT JOIN
              tbl_courses b
          ON
              a.tbl_course_id = b.course_id
          WHERE
            tbl_users_id = {$id}
      ");

      // 3. Disconnect from the database.
      disconnect($link);

      // 4. Return the result set.
      return $result;
    }

    // Retrieves all the courses available in the database for a dropdown list.
    function get_all_courses_dropdown()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT course_id, crsname
            FROM tbl_courses
            ORDER BY crsname ASC
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves all the notes that are assigned to a praticular user_id
    function get_all_notes($id)
    {
        // 1. Connect to the database.
        $link = connect();

        $id = mysqli_real_escape_string($link, $id);

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT
                a. note_id,
                a. title,
                a. note,
                b. crsname
            FROM
                tbl_notes a
            LEFT JOIN
                tbl_courses b
            ON
                a.tbl_courses_id = b.course_id
            WHERE
              tbl_users_id = {$id}
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves all the tasks for the selected course.
    function get_all_tasks($course_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variables.
        $course_id = mysqli_real_escape_string($link, $course_id);

        // 3. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT *
            FROM tbl_tasks
            WHERE course_id = {$course_id}
            ORDER BY tskname ASC
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves all the tasks and course deadlines.
    function get_all_task_deadlines($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variables.
        $id = mysqli_real_escape_string($link, $id);

        $result = mysqli_query($link, "
        SELECT
                a.task_id,
                a.tskname,
                a.deadline,
                a.course_id,
                b.crsname,
                c.tbl_users_id
            FROM
                tbl_tasks a
            LEFT JOIN
                tbl_courses b
            ON
                a.course_id = b.course_id
            LEFT JOIN
                tbl_enrollment c
            ON
                a.course_id = c.tbl_course_id
            WHERE
                c.tbl_users_id = {$id}
            ORDER BY deadline ASC
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves a single course from the database.
    function get_course($id)
    {

        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                crsname AS 'course-name',
                code AS 'course-code'
            FROM tbl_courses
            WHERE course_id = {$id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Checks the code a user inputs with the database.
    function get_course_code($code)
    {
        // 1. Connect to the database.
        $link = connect();

        $code = mysqli_real_escape_string($link, $code);

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT course_id
            FROM tbl_courses
            WHERE
                code = '{$code}'
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        if (mysqli_num_rows($result) > 1)
        {
            return FALSE;
        }

        // 5. Gets the matching reuslt
        $row = mysqli_fetch_assoc($result);

        // 6. Returns the result
        return $row['course_id'];
    }

    // Retrieves a single note from the database.
    function get_note($noteid)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $noteid = mysqli_real_escape_string($link, $noteid);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                title AS 'note-name',
                note AS 'note-body',
                tbl_courses_id AS 'note-course'
            FROM tbl_notes
            WHERE note_id = {$noteid}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Retrieves a list of students enrolled in a particular course
    function get_student_list($course_id)
    {
      // 1. Connect to the database.
      $link = connect();

      // 2. Protect the variables.
      $course_id = mysqli_real_escape_string($link, $course_id);

      $result = mysqli_query($link, "
      SELECT
              a.tbl_course_id,
              b.email,
              c.name,
              c.surname
          FROM
              tbl_enrollment a
          LEFT JOIN
              tbl_users b
          ON
              a.tbl_users_id = b.id
          LEFT JOIN
              tbl_user_details c
          ON
              a.tbl_users_id = c.users_id
          WHERE
              a.tbl_course_id = {$course_id}
          ORDER BY name ASC
      ");

      // 3. Disconnect from the database.
      disconnect($link);

      // 4. Return the result set.
      return $result;
    }

    // Retrieves a single task from the database.
    function get_task($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                tskname AS 'task-name',
                description AS 'task-desc',
                deadline AS 'task-deadline',
                course_id AS 'task-course'
            FROM tbl_tasks
            WHERE task_id = {$id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Retrieves the login data for a user.
    function get_login_data($id, $ip_address)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $ip_address = mysqli_real_escape_string($link, $ip_address);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                a.id,
                a.email,
                b.name,
                b.surname,
                c.auth_code,
                c.expiration
            FROM
                tbl_users a
            LEFT JOIN
                tbl_user_details b
            ON
                a.id = b.users_id
            LEFT JOIN
                tbl_user_auth c
            ON
                a.id = c.tbl_users_id
            WHERE
                a.id = {$id} AND c.ip_address = '{$ip_address}'
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Checks if a user has admin access
    function is_admin($id)
    {
      // 1. Connect to the database.
      $link = connect();

      $id = mysqli_real_escape_string($link, $id);

      // 2. Retrieve all the rows from the table.
      $result = mysqli_query($link, "
          SELECT
              tbl_roles_id AS 'role_id'
          FROM tbl_users
          WHERE id = {$id}
      ");

      // 3. Disconnect from the database.
      disconnect($link);

      // 4. Return the result set.
      if (mysqli_num_rows($result) > 1)
      {
          return FALSE;
      }

      // 5. Gets the matching reuslt
      $row = mysqli_fetch_assoc($result);

      // 6. Returns the result
      return $row['role_id'];
    }

    // Checks that a user is logged into the system
    function is_logged()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. we'll need the information from the cookies.
        $id         = array_key_exists('id', $_COOKIE) ? $_COOKIE['id'] : 0;
        $auth_code  = array_key_exists('auth_code', $_COOKIE) ? $_COOKIE['auth_code'] : '';
        // 3. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $auth_code = mysqli_real_escape_string($link, $auth_code);
        $expiration = mysqli_real_escape_string($link, time());
        // 4. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT tbl_users_id
            FROM tbl_user_auth
            WHERE
                tbl_users_id = {$id} AND
                auth_code = '{$auth_code}' AND
                expiration > {$expiration}
        ");
        // 5. Disconnect from the database.
        disconnect($link);

        // 6. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // Writes the new login data to the auth table.
    function set_login_data($id, $code, $ip_address, $expiration)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_user_auth
                (tbl_users_id, auth_code, ip_address, expiration)
            VALUES
                (?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'issi', $id, $code, $ip_address, $expiration);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_affected_rows($stmt);
    }

  	// generates a random code
  	function random_code($limit = 8)
  	{
  	    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
  	}

    // Registers a user's login data.
    function register_login_data($email, $password, $salt, $role)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. protect the password using blowfish.
        $password = password_hash($salt.$password, CRYPT_BLOWFISH);

        $time = time();

        // 3. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_users
                (email, password, salt, creation_date, tbl_roles_id)
            VALUES
                (?, ?, ?, ?, ?)
        ");

        // 4. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'sssii', $email, $password, $salt, $time, $role);

        // 5. Execute the statement.
        mysqli_stmt_execute($stmt);

        // echo mysqli_error($link); die;

        // 6. Disconnect from the database.
        disconnect($link);

        // 7. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Registers a user's login data.
    function register_user_details($id, $name, $surname)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_user_details
                (users_id, name, surname)
            VALUES
                (?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer string string
        mysqli_stmt_bind_param($stmt, 'iss', $id, $name, $surname);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_affected_rows($stmt);
    }


?>
