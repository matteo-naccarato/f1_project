create table db_f1.products
(
    id          int auto_increment
        primary key,
    title       varchar(50)               not null,
    description varchar(500)              null,
    price       int                       not null,
    img_url     varchar(700)              null,
    team_id     int                       null,
    color       varchar(20)               null,
    size        varchar(20) default 'one' not null,
    constraint team___fk
        foreign key (team_id) references db_f1.teams (id)
            on update cascade on delete cascade
);

