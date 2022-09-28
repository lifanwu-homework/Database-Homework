<html>

<head>
    <title>userpage</title>
</head>

<body>
    <div>
        书名：
        <input type="text" id="book_name">
        作者：
        <input type="text" id="author">
        出版社：
        <input type="text" id="publisher">

        <input type="button" onclick="search_book();" value="查询书籍">
        <a href="./userspace.php">个人空间</a>
    </div>
    <div id="book_table">

    </div>
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
<script src="//cdn.bootcss.com/jquery/3.0.0-alpha1/jquery.min.js"></script>

<script>
    //根据用户传过来的变量生成表格中行的方法
    var createTr_using_dic = function(data, other_elements = null) {
        var tr = document.createElement('tr');
        for (var i in data) {
            var td = document.createElement('td');
            td.innerHTML = data[i];
            tr.appendChild(td);
        }
        if (other_elements == null) return tr;
        for (i = 0; i < other_elements.length; i++) {
            // console.log(typeof(element));
            tr.appendChild(other_elements[i]);
        }
        return tr;
    }

    function borrow_book(book_id) {
        $.ajax({
            type: "post",
            url: "./sql_lib/borrow_book.php",
            data: {
                book_id: book_id,
            }, //提交到demo.php的数据
            dataType: "json", //回调函数接收数据的数据格式
            success: function(msg) {

                // var data = '';
                // if (msg != '') {
                //     data = eval(msg); //将返回的json数据进行解析，并赋给data
                // }
                alert(msg['responseText']);
                console.log(msg); //控制台输出
            },
            error: function(msg) {
                alert(msg['responseText']);
                console.log(msg);
            }
        });
        search_book();
    }

    function buildTable(data) {
        //定义表格
        var table = document.createElement('table');
        table.setAttribute('style', 'width: 450px;');
        table.id = 'book_info_table';
        //定义表格标题
        var caption = document.createElement('caption');
        caption.innerHTML = '书籍信息表';

        //将标题添加进表格
        table.appendChild(caption);
        head = {
            "1": "book_id",
            "2": "book_name",
            "3": "author",
            "4": "publisher",
            "5": "num"
        };
        table.appendChild(createTr_using_dic(head));
        table.childNodes[1].setAttribute('style', 'background:#cae8ea;');
        //alert(table.firstChild);
        //for循环json对象,然后将循环到的对象通过createTr()方法生成行，添加到table中
        for (var i = 0; i < data.length; i++) {
            // table.appendChild(createTr(data[i].book_id, data[i].book_name, data[i].author, data[i].publisher, data[i].num, 1));
            var book_id = data[i].book_id;
            var td_borrow = document.createElement('input');
            td_borrow.setAttribute("onclick", "borrow_book(" + book_id + ");");
            td_borrow.value = '借阅';
            td_borrow.type = "button";
            var other_elements = [];
            other_elements.push(td_borrow);
            table.appendChild(createTr_using_dic(data[i], other_elements));
        }
        return table;
    }

    function search_book() {
        var book_name = document.getElementById('book_name').value;
        var author = document.getElementById('author').value;
        var publisher = document.getElementById('publisher').value;
        $.ajax({
            type: "post",
            url: "./sql_lib/search_book.php",
            data: {
                book_name: book_name,
                author: author,
                publisher: publisher
            }, //提交到demo.php的数据
            dataType: "json", //回调函数接收数据的数据格式
            success: function(msg) {
                console.log(msg); //控制台输出
                var data = '';
                if (msg != '') {
                    data = eval(msg); //将返回的json数据进行解析，并赋给data
                }
                var temp = document.getElementById("book_info_table");
                if (temp != null)
                    document.getElementById("book_table").removeChild(temp);
                document.getElementById("book_table").appendChild(buildTable(data));
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    }
</script>

</html>