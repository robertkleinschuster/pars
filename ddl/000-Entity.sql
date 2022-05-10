create table if not exists Entity
(
    Entity_ID          uuid         not null default uuid(),
    Entity_ID_Parent   uuid,
    Entity_ID_Template uuid,
    Entity_ID_Original uuid,

    Entity_Type        varchar(32)  not null default '',
    Entity_Context     varchar(32)  not null default '',
    Entity_Group       varchar(32)  not null default '',
    Entity_State       varchar(32)  not null default '',
    Entity_Language    varchar(2)   not null default '',
    Entity_Country     varchar(2)   not null default '',
    Entity_Code        varchar(64)  not null default '',
    Entity_Name        varchar(255) not null default '',
    Entity_Data        json         not null default '{}',
    Entity_Options     json         not null default '{}',

    Entity_Order       integer,
    Entity_Created     timestamp    not null default current_timestamp(),
    Entity_Modified    timestamp    not null default current_timestamp() on update current_timestamp(),

    constraint PK_Entity
        primary key (Entity_ID),
    constraint FK_Entity_ID_Parent
        foreign key (Entity_ID_Parent) references Entity (Entity_ID)
            on update cascade on delete cascade,
    constraint FK_Entity_ID_Template
        foreign key (Entity_ID_Template) references Entity (Entity_ID)
            on update cascade on delete cascade,
    constraint FK_Entity_ID_Original
        foreign key (Entity_ID_Original) references Entity (Entity_ID)
            on update cascade on delete cascade,
    constraint Entity_Data
        check (json_valid(Entity_Data)),
    constraint Entity_Options
        check (json_valid(Entity_Options))
);

create unique index if not exists IDX_Entity_ID
    on Entity (Entity_ID);

create index if not exists IDX_Entity_Type
    on Entity (Entity_Type);

create index if not exists IDX_Entity_Context
    on Entity (Entity_Context);

create index if not exists IDX_Entity_Group
    on Entity (Entity_Group);

create index if not exists IDX_Entity_State
    on Entity (Entity_State);

create index if not exists IDX_Entity_Language
    on Entity (Entity_Language);

create index if not exists IDX_Entity_Country
    on Entity (Entity_Country);

create index if not exists IDX_Entity_Code
    on Entity (Entity_Code);

create index if not exists IDX_Entity_Order
    on Entity (Entity_Order);

create index if not exists IDX_Entity_Name
    on Entity (Entity_Name);

create or replace trigger TR_Entity_Order
    before insert
    on Entity for each row
begin
    set NEW.Entity_Order = COALESCE(
            NEW.Entity_Order,
            (select max(Entity_Order) + 1
            from Entity
            where Entity_Type = NEW.Entity_Type),
            0
        );
end;