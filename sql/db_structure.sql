create table users (
    user_id char(26) primary key,
    
    username varchar(20) unique not null,
    email varchar(254) unique not null,
    fullname varchar(100) not null,
    password char(60) not null,
    role enum('superadmin', 'admin', 'user') default 'user',
    
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

create table topics (
    topic_id char(26) primary key,
    topic_name varchar(50) unique not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

create table threads (
    thread_id char(26) primary key,
    thread_title varchar(100) not null,
    thread_description text not null,
    author_id char(26) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,

    foreign key (author_id) references users(user_id)
);

create table thread_topic (
    thread_id char(26) not null,
    topic_id char(26) not null,
    assigned_by char(26) not null,
  
    primary key (thread_id, topic_id),

    foreign key (thread_id) references threads(thread_id),
    foreign key (topic_id) references topics(topic_id),
    foreign key (assigned_by) references users(user_id)
);

create table bookmarks (
    bookmark_id char(26) primary key,
    user_id char(26) not null,
    thread_id char(26) not null,
    created_at timestamp default current_timestamp,
    
    foreign key (user_id) references users(user_id),
    foreign key (thread_id) references threads(thread_id)
);

create table comments (
    comment_id char(26) primary key,
    content text not null,
    thread_id char(26) not null,
    author_id char(26) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    
    foreign key (thread_id) references threads(thread_id),
    foreign key (author_id) references users(user_id)
);

create table reports (
    report_id char(26) primary key,
    thread_id char(26) not null,
    reporter_id char(26) not null,
    reason text not null,
    status enum('pending', 'takedown', 'warning', 'dismissed') default 'pending',
    reported_at timestamp default current_timestamp,
    
    foreign key (thread_id) references threads(thread_id),
    foreign key (reporter_id) references users(user_id)
);