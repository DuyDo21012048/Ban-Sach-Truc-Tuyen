<?php

session_start();

include 'db.php';
include 'admin_auth.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $parent_id = intval($_POST['parent_id']);

    $name =
    mysqli_real_escape_string(
        $conn,
        trim($_POST['name'])
    );

    if($parent_id && $name != ''){

        mysqli_query($conn,"
            INSERT INTO categories(
                name,
                parent_id
            )
            VALUES(
                '$name',
                $parent_id
            )
        ");
    }

}

header("Location: admin_categories.php");
exit;