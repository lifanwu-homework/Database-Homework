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
$book_name = $_POST['book_name'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];
try {
    $conn = start_sql();
    // Check connection
    $book_name = mysqli_real_escape_string($conn, $book_name);
    $author = mysqli_real_escape_string($conn, $author);
    $publisher = mysqli_real_escape_string($conn, $publisher);

    $sql = "select * from book_info where ";
    if ($book_name != "")
        $sql = $sql . "book_name=\"$book_name\" and ";
    if ($author != "")
        $sql = $sql . "author=\"$author\" and ";
    if ($publisher != "")
        $sql = $sql . "publisher=\"$publisher\" and ";
    $sql = $sql . "1=1;";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
} catch (mysqli_sql_exception  $e) {
    die("Error connect mysql" . $e->getMessage() . "<br/>");
}
$arr = array();
while ($row = mysqli_fetch_array($result)) {
    $count = count($row);
    for ($i = 0; $i < $count; $i++) {
        unset($row[$i]); //删除冗余数据  
    }
    array_push($arr, $row);
}
echo json_encode($arr,JSON_UNESCAPED_UNICODE);