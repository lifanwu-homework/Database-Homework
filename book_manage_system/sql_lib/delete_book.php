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
if($_user_id!=0){
    echo '没有权限删除!';
    exit;
}
try {
    $conn = start_sql();
    // Check connection
    $book_id = (mysqli_real_escape_string($conn, $book_id));
    $_user_id = (mysqli_real_escape_string($conn, $_user_id));
    $sql = "delete from book_info where book_id=" . "$book_id" . ";";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        echo "删除失败!请先删除相应的借阅记录!";
        mysqli_close($conn);
        exit;
    } else {
        echo "删除成功!";
    }
    mysqli_close($conn);
} catch (mysqli_sql_exception  $e) {
    die("Error connect mysql" . $e->getMessage() . "<br/>");
}
