<html>

<head>
    <title>visitorpage</title>
</head>

<body>
    <?php
    session_start(); //开启session
    //判断登录时的session是否存在 如果存在则表示已经登录
    if (!$_SESSION['islogin']) {
        // !$_SESSION['islogin']  表示不存在 回到登录页面
        header("Location:./login.html");
        exit;
    }
    //已经登录后的其他业务逻辑处理代码
    
    ?>

</body>

</html>