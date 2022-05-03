create table if not exists User
(
    User_ID       uuid        not null default uuid(),
    User_Name     varchar(64) not null default '',
    User_Password varchar(64) not null default '',
    User_Data     json        not null default '{}',
    User_Created  timestamp   not null default current_timestamp(),
    User_Modified timestamp   not null default current_timestamp() on update current_timestamp(),
    constraint PK_User
        primary key (User_ID),
    constraint User_Data
        check (json_valid(User_Data))
);

create unique index if not exists IDX_User_ID
    on User (User_ID);

create index if not exists IDX_User_Name
    on User (User_Name);
