drop table if exists reports;
drop table if exists bookmarks;
drop table if exists comments;
drop table if exists thread_topic;
drop table if exists threads;
drop table if exists topics;
drop table if exists users;

create table users (
    user_id char(26) primary key,
    username varchar(20) unique not null,
    email varchar(254) unique not null,
    fullname varchar(100) not null,
    password char(60) not null,
    role enum('superadmin', 'moderator', 'user') default 'user',
    status enum('active', 'banned', 'restricted') default 'active',
    avatar_url varchar(255) null,

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
    is_active tinyint(1) default 1,
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

    unique key uq_bookmark (user_id, thread_id),

    foreign key (user_id) references users(user_id),
    foreign key (thread_id) references threads(thread_id)
);

create table comments (
    comment_id char(26) primary key,
    content text not null,
    parent_comment_id char(26) null,
    thread_id char(26) not null,
    author_id char(26) not null,
    is_active tinyint(1) default 1,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,

    foreign key (thread_id) references threads(thread_id),
    foreign key (author_id) references users(user_id),
    foreign key (parent_comment_id) references comments(comment_id)
);

create table reports (
    report_id char(26) primary key,
    thread_id char(26) null,
    comment_id char(26) null,
    reporter_id char(26) not null,
    reason text not null,
    status enum('pending', 'takedown', 'warning', 'dismissed') default 'pending',
    reviewed_by char(26) null,
    reported_at timestamp default current_timestamp,
    reviewed_at timestamp null,

    foreign key (thread_id) references threads(thread_id),
    foreign key (comment_id) references comments(comment_id),
    foreign key (reporter_id) references users(user_id),
    foreign key (reviewed_by) references users(user_id)
);

-- Seed: Default Super Admin
-- Password: admin123 (bcrypt)
insert into users (user_id, username, email, fullname, password, role, status) values (
    '01HWXXXXXXXXXXXXXXXXSADMIN',
    'superadmin',
    'admin@forit.id',
    'Super Administrator',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'superadmin',
    'active'
);

-- Seed: Default Topics
insert into topics (topic_id, topic_name) values
    ('01HWXXXXXXXXXXXXXXXXTOPIC1', 'Pemrograman'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC2', 'Jaringan & Sistem'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC3', 'Keamanan Siber'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC4', 'Kecerdasan Buatan'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC5', 'Database'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC6', 'Web Development'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC7', 'Mobile Development'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC8', 'Cloud Computing'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC9', 'Open Source'),
    ('01HWXXXXXXXXXXXXXXXXTOPIC0', 'Diskusi Umum');