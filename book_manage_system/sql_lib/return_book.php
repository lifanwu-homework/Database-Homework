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
$borrow_date=$_POST['borrow_date'];
$return_date=$_POST['return_date'];

try {
    $conn = start_sql();
    // Check connection
    $book_id = (mysqli_real_escape_string($conn, $book_id));
    $_user_id = (mysqli_real_escape_string($conn, $_user_id));
    $borrow_date = (mysqli_real_escape_string($conn, $borrow_date));
    $return_date = (mysqli_real_escape_string($conn, $return_date));
    $sql = "select * from borrow where book_id=" . "$book_id" . " and "."_user_id="."$_user_id";
    $sql = $sql." and borrow_date=\""."$borrow_date"."\" and return_date=\""."$return_date"."\";";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if(mysqli_fetch_array($result)==false)
    {
        echo "归还失败!";
        mysqli_close($conn);
        exit;
    }
    $sql = "delete from borrow where book_id=" . "$book_id" . " and "."_user_id="."$_user_id";
    $sql = $sql." and borrow_date=\""."$borrow_date"."\" and return_date=\""."$return_date"."\";";
    
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        echo "归还失败!";
        mysqli_close($conn);
        exit;
    }
    $sql = "update book_info set num=num+1 where book_id=" . "$book_id" . ";";
    
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if($result==true)
    {
        echo "归还成功!";
    }
    mysqli_close($conn);
} catch (mysqli_sql_exception  $e) {
    die("Error connect mysql" . $e->getMessage() . "<br/>");
}
