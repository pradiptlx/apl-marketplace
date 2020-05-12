create table cart
(
    id         varchar(150) not null,
    product_id varchar(150) not null,
    user_id    varchar(150) not null,
    created_at datetime     not null
)
go

create unique index cart_id_uindex
    on cart (id)
go

create table product
(
    id               varchar(150)          not null
        constraint product_pk
            primary key nonclustered,
    product_name     varchar(150)          not null,
    description      text,
    stock            int         default 0 not null,
    price            varchar(50) default 0 not null,
    wishlist_counter int         default 0,
    user_id          varchar(150)          not null,
    created_at       datetime              not null,
    updated_at       datetime
)
go

create unique index product_id_uindex
    on product (id)
go

create table [user]
(
    id          uniqueidentifier not null
        primary key,
    username    varchar(150)     not null,
    fullname    varchar(150)     not null,
    email       varchar(150)     not null,
    address     varchar(max)     not null,
    telp_number varchar(20)      not null,
    status_user varchar(10)      not null,
    password    varchar(max)     not null,
    created_at  datetime         not null,
    updated_at  datetime
)
go

create unique index User_id_uindex
    on [user] (id)
go

create unique index User_username_uindex
    on [user] (username)
go

create unique index User_email_uindex
    on [user] (email)
go

create unique index user_telp_number_uindex
    on [user] (telp_number)
go


