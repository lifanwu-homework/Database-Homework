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
$book_name = $_POST['book_name'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];
$num = $_POST['num'];

$_user_id = $_SESSION['_user_id'];
if ($_user_id != 0) {
    echo '没有权限增加书籍!';
    exit;
}
try {
    $conn = start_sql();
    // Check connection
    $_user_id = (mysqli_real_escape_string($conn, $_user_id));
    $book_id = (mysqli_real_escape_string($conn, $book_id));
    $book_name = (mysqli_real_escape_string($conn, $book_name));
    $author = (mysqli_real_escape_string($conn, $author));
    $publisher = (mysqli_real_escape_string($conn, $publisher));
    $num = (mysqli_real_escape_string($conn, $num));
    // if($book_name=null)
    // {
    //     $book_name='NULL';
    // }
    $sql = "INSERT INTO book_info VALUE($book_id,'$book_name','$author','$publisher',$num);";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        echo "插入失败!";
        mysqli_close($conn);
        exit;
    } else {
        echo "插入成功!";
    }
    mysqli_close($conn);
} catch (mysqli_sql_exception  $e) {
    die("Error connect mysql" . $e->getMessage() . "<br/>");
}
