create table User
(
    Person_ID uuid not null,
    User_Name     varchar(64) default '' not null,
    User_Password varchar(64) default '' not null,
    primary key (Person_ID),
    constraint User_Person_ID_uindex
        unique (Person_ID),
    constraint User_Person_ID
        foreign key (Person_ID) references Person (Person_ID)
            on update cascade on delete cascade
);

create index User_Name_index
    on User (User_Name);

