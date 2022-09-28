<html>

<head>
    <title>userpage</title>
    <!-- <link href="https://cdn.bootcss.com/twitter-bootstrap/3.4.1/css/bootstrap.css" rel="stylesheet"> -->
    <style>
        .table {
            /* border-right: 1px solid #804040; */
            /* border-bottom: 1px solid #804040; */
            border-collapse: collapse;
        }

        .table td {
            /* border-left: 1px solid #804040; */
            /* border-top: 1px solid #804040; */
            border: 1px solid #804040;
            /* border-collapse: collapse; */
        }

        .container {
            width: 580px;
            margin-top: 10px;
        }

        /* input[type=text] {
            border: none !important;
            outline: none !important;
            text-align: center;
            /*height: 30px;*/
        }

        */ input[type=text]:focus {
            border: 1px solid #bbb !important;
            border-radius: 3px;
            text-align: left;
        }

        input:read-only {
            border: none !important;
            text-align: center;
        }

        select {
            border: none;
            outline: none;
        }

        select:focus {
            border: 1px solid #bbb !important;
            border-radius: 3px;
        }
    </style>

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
    <div id="insert_info">
        id：
        <input type="text" id="book_id">
        书名：
        <input type="text" id="book_name">
        作者：
        <input type="text" id="author">
        出版社：
        <input type="text" id="publisher">
        数量：
        <input type="text" id="num">
        <input type="button" onClick="insert_book();" value="增加书籍">
        <a href="./userspace.php">个人空间</a>
    </div>
    <table id="book_table" class="container table table-bordered text-center">

    </table>
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
    var create_volatile_Tr_using_dic = function(data, other_elements = null) {
        var tr = document.createElement('tr');
        for (var i in data) {
            var td = document.createElement('td');
            var input_ = document.createElement('input');
            input_.name = "text";
            input_.type = "text";
            input_.value = data[i];
            input_.readOnly = "readOnly";
            // input_.size="5";
            td.appendChild(input_);
            tr.appendChild(td);
        }
        if (other_elements == null) return tr;
        for (i = 0; i < other_elements.length; i++) {
            // console.log(typeof(element));
            tr.appendChild(other_elements[i]);
        }
        return tr;
    }
    var temp_book_id = 0;

    function alter_book(button_id) {
        button = document.getElementById(button_id);
        book_td = button.parentElement;
        if (button.value == "修改") {

            button.value = "确认";
            temp_book_id = book_td.children[0].children[0].value;
            for (i = 0; i < book_td.childElementCount; i++) {
                temp_td = book_td.children[i];
                if (temp_td.children[0] != null) {
                    temp_td.children[0].removeAttribute("readonly");
                }
            }
        } else {
            if (button.value == "确认") {
                button.value = "修改";
                for (i = 0; i < book_td.childElementCount; i++) {
                    temp_td = book_td.children[i];
                    if (temp_td.children[0] != null)
                        temp_td.children[0].setAttribute("readonly", "readonly");
                }
                // delete_book(book_td.children[0].children[0].value);
                update_book(book_td);
            }
        }
    }

    function update_book(book_td) {
        $.ajax({
            type: "post",
            url: "./sql_lib/update_book.php",
            data: {
                book_id: book_td.children[0].children[0].value,
                book_name: book_td.children[1].children[0].value,
                author: book_td.children[2].children[0].value,
                publisher: book_td.children[3].children[0].value,
                num: book_td.children[4].children[0].value,
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

    function insert_book() {
        insert_info=document.getElementById("insert_info");
        console.log(insert_info.children[0].value);
        $.ajax({
            type: "post",
            url: "./sql_lib/insert_book.php",
            data: {
                book_id: insert_info.children[0].value,
                book_name: insert_info.children[1].value,
                author: insert_info.children[2].value,
                publisher: insert_info.children[3].value,
                num: insert_info.children[4].value,
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

    function delete_book(book_id) {
        // delete_num=document.getElementById('delete_num'+book_id).value;
        $.ajax({
            type: "post",
            url: "./sql_lib/delete_book.php",
            data: {
                book_id: book_id,
                // delete_num:delete_num,
            }, //提交到demo.php的数据
            dataType: "json", //回调函数接收数据的数据格式
            success: function(msg) {
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
        // table.setAttribute('style', 'width: 450px;');
        table.id = 'book_info_table';
        //定义表格标题
        var caption = document.createElement('caption');
        caption.innerHTML = '书籍信息表';

        //将标题添加进表格
        table.appendChild(caption);
        //调用createTr()方法生成标题行并将其添加到table中。
        head = {
            "1": "book_id",
            "2": "book_name",
            "3": "author",
            "4": "publisher",
            "5": "num"
        };
        table.appendChild(create_volatile_Tr_using_dic(head));
        // table.appendChild(createTr('book_id', 'book_name', 'author', 'publisher', 'num', 0));
        // table.childNodes[1].setAttribute('style', 'background:#cae8ea;');
        //alert(table.firstChild);
        //for循环json对象,然后将循环到的对象通过createTr()方法生成行，添加到table中
        for (var i = 0; i < data.length; i++) {
            // table.appendChild(createTr(data[i].book_id, data[i].book_name, data[i].author, data[i].publisher, data[i].num, 1));
            var book_id = data[i].book_id;
            var td_alter = document.createElement('input');
            td_alter.setAttribute("onclick", "alter_book(this.id);");
            td_alter.value = '修改';
            td_alter.id = 'alter' + book_id;
            td_alter.type = "button";
            // tr.appendChild(td_alter);

            var td_delete = document.createElement('input');
            td_delete.setAttribute("onclick", "delete_book(" + book_id + ");");
            td_delete.value = '删除';
            td_delete.type = "button";
            // tr.appendChild(td_delete);
            var other_elements = [];
            other_elements.push(td_alter);
            other_elements.push(td_delete);
            table.appendChild(create_volatile_Tr_using_dic(data[i], other_elements));
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