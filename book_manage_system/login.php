<?php
include "./sql_lib/sql.php";
$selector = $_REQUEST['selector'];
// echo "用户名:" . $_REQUEST['username'] . "<br>密码:" . $_REQUEST['password'] . $_REQUEST['selector'];
if ($selector == "guest") {
    session_start();
    $_SESSION['islogin'] = true;
    header("Location: ./visitorpage.php");
    exit;
}
if ($selector == "ordinary_user") {
    $username = $_REQUEST['username'];

    $password = $_REQUEST['password'];

    try {
        $conn = start_sql();
        // Check connection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $sql = "select _user_id from user_index where _username=\"$username\" and _password=\"$password\";";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['islogin'] = true;
            $_SESSION['_user_id'] = $row["_user_id"];
            $_SESSION['sql'] = $sql;
            echo "登陆成功!";
            header("Location: ./userpage.php");
            exit;
        } else {
            header("Location: ./error.html");
        }
        mysqli_close($conn);
    } catch (mysqli_sql_exception  $e) {
        die("Error connect mysql" . $e->getMessage() . "<br/>");
    }
}


if ($selector == "admin") {
    $username = $_REQUEST['username'];

    $password = $_REQUEST['password'];

    try {
        $conn = start_sql();
        // Check connection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $sql = "select _user_id from user_index where _username=\"$username\" and _password=\"$password\";";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["_user_id"] != 0) {
                header("Location: ./error.html");
            } else {
                session_start();
                $_SESSION['islogin'] = true;
                $_SESSION['_user_id'] = $row["_user_id"];
                $_SESSION['sql'] = $sql;
                echo "登陆成功!";
                header("Location: ./adminpage.php");
                exit;
            }
        } else {
            header("Location: ./error.html");
        }
        mysqli_close($conn);
    } catch (mysqli_sql_exception  $e) {
        die("Error connect mysql" . $e->getMessage() . "<br/>");
    }
}
