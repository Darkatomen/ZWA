<?php
    $users = array(
        array(
            "id" => 1,
            "username" => "honzik",
            "firstname" => "Jan",
            "lastname" => "Pražák",
            "passwordhash" => password_hash("tajneHeslo", PASSWORD_DEFAULT),
            "userRole" => "admin"
        ),
        array(
            "id" => 2,
            "username" => "admin",
            "firstname" => "Robert",
            "lastname" => "Adminton",
            "passwordhash" => password_hash("tajneHeslo", PASSWORD_DEFAULT),
            "userRole" => "admin"
        ),
        array(
            "id" => 3,
            "username" => "franta",
            "firstname" => "Franta",
            "lastname" => "Běžnýuživatel",
            "passwordhash" => password_hash("beznyUzivatel", PASSWORD_DEFAULT),
            "userRole" => "user"
        )
    );

    function getUserByUsername($username, $users)
    {
        foreach ($users as $user)
        {
            if ($user['username'] == $username)
            {
                return $user;
            }
        }
        return NULL;
    }

    function getUserById($userId, $users)
    {
        foreach ($users as $user)
        {
            if ($user['id'] == $userId)
            {
                return $user;
            }
        }
        return NULL;
    }
?>