<?php
session_start(); //开启session
//判断登录时的session是否存在 如果存在则表示已经登录
if (!$_SESSION['islogin']) {
    // !$_SESSION['islogin']  表示不存在 回到登录页面
    header("Location:./login.html");
    exit;
}
//已经登录后的其他业务逻辑处理代码

include "./sql.php";
header('Content-type:text/json;charset=utf-8');
$book_id = $_POST['book_id'];
$_user_id = $_SESSION['_user_id'];
try {
    $conn = start_sql();
    // Check connection
    $book_id = (mysqli_real_escape_string($conn, $book_id));
    $_user_id = (mysqli_real_escape_string($conn, $_user_id));
    $sql = "update book_info set num=num-1 where book_id=" . "$book_id" . ";";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        echo "借阅失败!";
        mysqli_close($conn);
        exit;
    }
    $time = time();
    $return_time = $time + 864000;
    $time = date("Y-m-d H:i:s", $time);
    $return_time = date("Y-m-d H:i:s", $return_time);
    // $sql = "select max(borrow_id) from borrow;";
    // // echo $sql;
    // $result = mysqli_query($conn, $sql);
    // $row = mysqli_fetch_array($result);
    // $borrow_id = $row[0];
    // echo $borrow_id;
    $sql = "insert into borrow VALUE($_user_id" . "," . "$book_id" . ",'" . "$time" . "','" . "$return_time" . "');";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result == true) {
        echo "借阅成功!";
    }
    mysqli_close($conn);
} catch (mysqli_sql_exception  $e) {
    die("Error connect mysql" . $e->getMessage() . "<br/>");
}
