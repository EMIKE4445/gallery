drop database if exists gallery;
CREATE DATABASE gallery;
use gallery;
create table users(
    id int primary key not null,
    username varchar(20) not null,
    email varchar(30) not null,
    user_password varchar(20) not null
);

create table images(
    id int primary key not null,
    image_name varchar(20) not null,
    user_id int references users(id),
    posted_at timestamp default current_timestamp not null

);
