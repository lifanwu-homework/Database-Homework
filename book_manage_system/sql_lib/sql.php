<?php
function start_sql()
{
    $servername = "localhost";
    $sql_username = "wusar";
    $sql_password = "123456";
    $dbname = "book_manage_system";
    try {
        $conn = mysqli_connect($servername, $sql_username, $sql_password, $dbname);
        // Check connection
        if (!$conn) {
            die("连接失败: " . mysqli_connect_error());
        }
        return $conn;
    } catch (mysqli_sql_exception  $e) {
        die("Error connect mysql" . $e->getMessage() . "<br/>");
    }
}
