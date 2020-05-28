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
    updated_at       datetime,
    image_path       varchar(150),
    cart_counter     int         default 0
)
go

create unique index product_id_uindex
    on product (id)
go

create table users
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

create table cart
(
    id         varchar(150)     not null,
    product_id varchar(150)     not null
        constraint cart_product_id_fk
            references product,
    user_id    uniqueidentifier not null
        constraint cart_users_id_fk
            references users,
    created_at datetime         not null
)
go

create unique index cart_id_uindex
    on cart (id)
go

create table [transaction]
(
    id                 varchar(150)     not null
        constraint transaction_pk
            primary key nonclustered,
    user_id            uniqueidentifier not null
        constraint transaction_users_id_fk
            references users
            on delete cascade,
    cart_id            varchar(150)     not null
        constraint transaction_cart_id_fk
            references cart (id)
            on delete cascade,
    payment_method     varchar(100)     not null,
    status_transaction varchar(50)      not null,
    created_at         datetime         not null,
    updated_at         datetime
)
go

create unique index transaction_id_uindex
    on [transaction] (id)
go

create unique index User_id_uindex
    on users (id)
go

create unique index User_username_uindex
    on users (username)
go

create unique index User_email_uindex
    on users (email)
go

create unique index user_telp_number_uindex
    on users (telp_number)
go

create table wishlist
(
    id         uniqueidentifier not null
        constraint wishlist_pk
            primary key nonclustered,
    product_id varchar(150)     not null
        constraint wishlist_product_id_fk
            references product
            on delete cascade,
    user_id    uniqueidentifier not null
        constraint wishlist_users_id_fk
            references users
            on delete cascade
)
go


