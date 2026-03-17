<?php

function getAllUsers($conn)
{
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

/* SQL INJECTION */
function getUserById($conn, $id)
{
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

/* SQL INJECTION + NO HASH */
function createUser($conn, $data)
{
    $sql = "INSERT INTO users 
        (username, password, full_name, email, phone, bio)
        VALUES (
            '{$data['username']}',
            '{$data['password']}',
            '{$data['full_name']}',
            '{$data['email']}',
            '{$data['phone']}',
            '{$data['bio']}'
        )";

    return mysqli_query($conn, $sql);
}

/* IDOR */
function deleteUser($conn, $id)
{
    $sql = "DELETE FROM users WHERE id = $id";
    return mysqli_query($conn, $sql);
}
