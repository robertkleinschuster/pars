create table Person
(
    Person_ID uuid default uuid() not null,
    Person_Name varchar(255)                 default ''   not null,
    Person_Data longtext collate utf8mb4_bin default '{}' not null,
    primary key (Person_ID)
);

alter table Person
    add constraint Person_Data
        check (json_valid(`Person_Data`));

