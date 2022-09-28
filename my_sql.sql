drop database book_manage_system;

create database book_manage_system;

use book_manage_system;

-- _user_id为0的用户为管理员，后面的均为普通用户
create table user_index (
    _user_id int,
    _username VARCHAR(25),
    _password VARCHAR(25),
    email VARCHAR(25),
    primary key(_user_id)
);

create table book_info(
    book_id int,
    book_name VARCHAR(25),
    author VARCHAR(25),
    publisher VARCHAR(25),
    num int,
    primary key(book_id),
    CONSTRAINT check(num>=0)
);

create table borrow(
    -- borrow_id int,
    _user_id int,
    book_id int,
    borrow_date datetime,
    return_date datetime,
    -- primary key(borrow_id),
    foreign key(_user_id) references user_index(_user_id),
    foreign key(book_id) references book_info(book_id)
);

INSERT INTO user_index VALUE(0,'admin','admin',NULL);
INSERT INTO user_index VALUE(1,'wusar','123456',NULL);
INSERT INTO user_index VALUE(2,'ordinary_user','123456',NULL);
INSERT INTO book_info VALUE(0,'test_book','wusar','wusar_publisher',3);
INSERT INTO book_info VALUE(1,'三体','刘慈欣','重庆出版社',1);
INSERT INTO book_info VALUE(2,'数学分析讲义','程艺','中国科学技术大学出版社',4);
INSERT INTO borrow VALUE(0,1,'2021-11-18 10:37:21','2021-11-28 10:37:21');
INSERT INTO borrow VALUE(1,1,'2021-11-18 10:37:21','2021-11-28 10:37:21');