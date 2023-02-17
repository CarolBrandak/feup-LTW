PRAGMA foreign_keys = ON;
BEGIN TRANSACTION;
.mode columns
.headers on
.nullvalue NULL


DROP TABLE IF EXISTS users;

CREATE TABLE users (
  userId INTEGER PRIMARY KEY,
  username VARCHAR NOT NULL,      
  password VARCHAR NOT NULL,                  
  Fname     VARCHAR NOT NULL,
  Lname    VARCHAR NOT NULL,
  adress   VARCHAR DEFAULT 'undefined',
  email    VARCHAR NOT NULL,
  phone    VARCHAR DEFAULT 'empty',
  photo STRING DEFAULT "default.jpg"                 
);

DROP TABLE IF EXISTS restaurants;

CREATE TABLE restaurants (
  id INTEGER PRIMARY KEY,            
  name VARCHAR NOT NULL,
  adress VARCHAR NOT NULL,
  category VARCHAR NOT NULL,
  photo STRING DEFAULT "default.jpg",
  owner INTEGER NOT NULL REFERENCES restaurantOwner(id) ON DELETE CASCADE
                      
);

DROP TABLE IF EXISTS menu;

CREATE TABLE menu (
  id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL,
  restaurant INTEGER NOT NULL REFERENCES restaurants(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS menu_item;

CREATE TABLE menu_item (
  id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL,
  price FLOAT NOT NULL,
  photo STRING DEFAULT "default.jpg",
  category VARCHAR NOT NULL,
  menu INTEGER NOT NULL REFERENCES menu(id) ON DELETE CASCADE,
  status INTEGER NOT NULL DEFAULT 1
);

DROP TABLE IF EXISTS customer; 

CREATE TABLE customer (
  id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL,
  username VARCHAR NOT NULL
); 

DROP TABLE IF EXISTS restaurantOwner;

CREATE TABLE restaurantOwner (
  id INTEGER PRIMARY KEY,
  user INTEGER NOT NULL REFERENCES users(userId) ON DELETE CASCADE
);

DROP TABLE IF EXISTS request; 

CREATE TABLE request (
  id INTEGER PRIMARY KEY,
  customer INTEGER NOT NULL REFERENCES customer(id) ON DELETE CASCADE,
  state VARCHAR NOT NULL
);
   

DROP TABLE IF EXISTS requestMenuItem;

CREATE TABLE RequestMenuItem (
  id INTEGER PRIMARY KEY,
  menu_item INTEGER NOT NULL REFERENCES menu_item(id) ON DELETE CASCADE,
  request INTEGER NOT NULL REFERENCES request(id) ON DELETE CASCADE,
  quantity INTEGER NOT NULL
);  

DROP TABLE IF EXISTS review;

CREATE TABLE review (
  id INTEGER PRIMARY KEY,
  customer INTEGER NOT NULL,
  restaurant INTEGER NOT NULL REFERENCES restaurants(id) ON DELETE CASCADE,
  rating INTEGER NOT NULL,
  comment VARCHAR NOT NULL,
  reply VARCHAR NOT NULL
);


DROP TABLE IF EXISTS favouriteRestaurant;

CREATE TABLE favouriteRestaurant (
  id INTEGER PRIMARY KEY,
  customer INTEGER NOT NULL REFERENCES customer(id) ON DELETE CASCADE,
  restaurant INTEGER NOT NULL REFERENCES restaurants(id) ON DELETE CASCADE
);


DROP TABLE IF EXISTS favouriteMenuItem;

CREATE TABLE favouriteMenuItem (
  id INTEGER PRIMARY KEY,
  customer INTEGER NOT NULL REFERENCES customer(id) ON DELETE CASCADE,
  menu_item INTEGER NOT NULL REFERENCES menu_item(id) ON DELETE CASCADE
);

INSERT INTO users (userId,username,password,Fname,Lname,adress,email,phone) VALUES (1,'admin','b5045cc120e1fcd12b46ed02b6872fe77d145983ab5ad1e752d73143203d4ce4', 'Main','Admin', 'Parque infantil da Cordoaria','admin13131313@gmail.com', '966969694');

INSERT INTO users (userId,username,password,Fname,Lname,adress,email,phone) VALUES (2,'joaquim','2ba65a6ce000ba58dcfc501eeff94d26063ebb310279d704ba85dcad930f84fc', 'Joaquim','Manel', 'aliados nº66','executeorder66@gmail.com', '932242469');

INSERT INTO users (userId,username,password,Fname,Lname,adress,email,phone) VALUES (3,'sergio','2ba65a6ce000ba58dcfc501eeff94d26063ebb310279d704ba85dcad930f84fc', 'Sérgio','Costa', 'praça dos hamburgueres','burguerlover24@gmail.com', '962242469');

INSERT INTO users (userId,username,password,Fname,Lname,adress,email,phone,photo) VALUES (4,'ben','49701266ac1b097969a1e40856c493356c4b02dc64aec656bbbec47d711185e9', 'Obi-Wan','Kenobi', 'Mustafar','youweremybrotheranakin@gmail.com', '912242469','4.jpg');

INSERT INTO users (userId,username,password,Fname,Lname,adress,email,phone,photo) VALUES (5,'yoda','49701266ac1b097969a1e40856c493356c4b02dc64aec656bbbec47d711185e9', 'Yoda','Grogu', 'Dagobah','thereisnotry@gmail.com', '912242569','5.jpeg');


INSERT INTO restaurantOwner (id,user) VALUES (1,1);

INSERT INTO restaurantOwner (id,user) VALUES (2,2);

INSERT INTO restaurantOwner (id,user) VALUES (3,3);

INSERT INTO customer (id,name,username) VALUES (1,'Obi-Wan Kenobi','ben');

INSERT INTO customer (id,name,username) VALUES (2,'Yoda Grogu','yoda');

INSERT INTO restaurants (id,name,adress,category,photo,owner) VALUES (1,'Taskinha','Rua do povo','Snacks','1.jpg',1);

INSERT INTO restaurants (id,name,adress,category,photo,owner) VALUES (2,'Aqua','Madalena','Snacks and Drinks','2.jpg',2);

INSERT INTO restaurants (id,name,adress,category,photo,owner) VALUES (3,'Food Corner','Bolhão','Fancy Fast Food','3.png',2);

INSERT INTO restaurants (id,name,adress,category,photo,owner) VALUES (4,'H3','Arrabida Shopping','Burguers','4.png',3);

INSERT INTO menu(id,name,restaurant) VALUES (1,'Snacks',1);

INSERT INTO menu(id,name,restaurant) VALUES (2,'Snacks',2);

INSERT INTO menu(id,name,restaurant) VALUES (3,'Drinks',2);

INSERT INTO menu(id,name,restaurant) VALUES (4,'Pizzas',3);

INSERT INTO menu(id,name,restaurant) VALUES (5,'Burguers',3);

INSERT INTO menu(id,name,restaurant) VALUES (6,'Burguers',4);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (1,'Rissol de carne',0.75,'1.jpeg','Snacks',1);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (2,'Batatas fritas',1,'2.jpeg','Fast food',1);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (3,'Panado',1.5,'3.jpg','Snacks',2);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (4,'Tosta Mista',1.25,'4.jpeg','Snacks',2);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (5,'Bloody Mary',2,'5.jpeg','Alcohol drinks',3);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (6,'Pizza Marguerita',7,'6.jpeg','Pizza n Pasta',4);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (7,'Pizza Napolitana',9,'7.jpeg','Pizza n Pasta',4);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (8,'Hamburguer com queijo',6,'8.jpeg','Burguers',5);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (9,'Hamburguer com molho',7,'9.jpg','Burguers',6);

INSERT INTO menu_item(id,name,price,photo,category,menu) VALUES (10,'Hamburguer vegie',8,'10.jpg','Burguers',6);



COMMIT TRANSACTION;

PRAGMA foreign_keys = ON;
  
  
