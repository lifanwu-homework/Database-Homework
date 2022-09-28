<html>

<head>
    <title>个人空间</title>
</head>

<body>
    <div id="basic_info">
        <a href="./userpage.php">继续借书</a>

    </div>
    <div id="book_table"></div>
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
    // var createTr = function(user_id, book_id, book_name, author, publisher, num, borrow_date, return_date, with_return_button) {
    //     //定义行元素标签
    //     var tr = document.createElement('tr');
    //     //定义列元素标签
    //     //设置该列节点的文本节点的值
    //     var td_user_id = document.createElement('td');
    //     td_user_id.innerHTML = user_id;
    //     tr.appendChild(td_user_id);

    //     var td_book_id = document.createElement('td');
    //     td_book_id.innerHTML = book_id;
    //     tr.appendChild(td_book_id);

    //     var td_book_name = document.createElement('td');
    //     td_book_name.innerHTML = book_name;
    //     tr.appendChild(td_book_name);

    //     var td_author = document.createElement('td');
    //     td_author.innerHTML = author;
    //     tr.appendChild(td_author);

    //     var td_publisher = document.createElement('td');
    //     td_publisher.innerHTML = publisher;
    //     tr.appendChild(td_publisher);

    //     var td_num = document.createElement('td');
    //     td_num.innerHTML = num;
    //     tr.appendChild(td_num);

    //     var td_borrow_date = document.createElement('td');
    //     td_borrow_date.innerHTML = borrow_date;
    //     tr.appendChild(td_borrow_date);

    //     var td_return_date = document.createElement('td');
    //     td_return_date.innerHTML = return_date;
    //     tr.appendChild(td_return_date);

    //     if (with_return_button) {
    //         var td_return = document.createElement('input');
    //         td_return.setAttribute("onclick", "return_book(" + book_id + ",\"" + borrow_date + "\",\"" + return_date + "\");");
    //         td_return.value = '归还';
    //         td_return.type = "button";
    //         tr.appendChild(td_return);
    //     }
    //     //tdGender.appendChild(document.createTextNode(gender)); //等价与 tdGender.innerHTML = gender;
    //     //将列值添加到行元素节点
    //     //返回生成的行标签
    //     return tr;
    // };

    function return_book(book_id, borrow_date, return_date) {
        $.ajax({
            type: "post",
            url: "./sql_lib/return_book.php",
            data: {
                book_id: book_id,
                borrow_date: borrow_date,
                return_date: return_date
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
        get_borrowed_book();
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
        //调用createTr()方法生成标题行并将其添加到table中。
        head = {
            "1": "借阅者id",
            "2": "书籍id",
            "3": "借阅日期",
            "4": "应还日期",
            "5": "书名",
            "6": "作者",
            "7": "出版社",
            "8": "数量",

        };
        table.appendChild(createTr_using_dic(head));
        table.childNodes[1].setAttribute('style', 'background:#cae8ea;');
        //alert(table.firstChild);
        //for循环json对象,然后将循环到的对象通过createTr()方法生成行，添加到table中
        for (var i = 0; i < data.length; i++) {
            var book_id = data[i].book_id;
            var borrow_date = data[i].borrow_date;
            var return_date = data[i].return_date;
            var td_return = document.createElement('input');
            td_return.setAttribute("onclick", "return_book(" + book_id + ",\"" + borrow_date + "\",\"" + return_date + "\");");
            td_return.value = '归还';
            td_return.type = "button";
            var other_elements = [];
            other_elements.push(td_return);
            table.appendChild(createTr_using_dic(data[i], other_elements));
        }
        return table;
    }

    function get_borrowed_book() {
        $.ajax({
            type: "post",
            url: "./sql_lib/get_borrowed_book.php",
            data: {}, //提交到demo.php的数据
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
    get_borrowed_book();
</script>



</html>