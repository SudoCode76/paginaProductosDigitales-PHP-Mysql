CREATE DATABASE loginCrudPrueba;
USE loginCrudPrueba;


CREATE TABLE roles (
    idroles INT PRIMARY KEY,
    nombreRol VARCHAR(45)
);

CREATE TABLE usuarios (
    idusuarios INT PRIMARY KEY,
    usuario VARCHAR(45),
    password VARCHAR(45),
    roles_idroles INT,
    FOREIGN KEY (roles_idroles) REFERENCES roles(idroles)
);

CREATE TABLE categoriasProducto (
    idcategoriasProducto INT PRIMARY KEY,
    nombreCategoria VARCHAR(45)
);

CREATE TABLE productoDigital (
    idproductoDigital INT PRIMARY KEY,
    tituloProducto VARCHAR(45),
    descripcionProducto VARCHAR(45),
    urlPortada VARCHAR(45),
    categoriasProducto_idcategorias INT,
    FOREIGN KEY (categoriasProducto_idcategorias) REFERENCES categoriasProducto(idcategoriasProducto)
);
ALTER TABLE productoDigital
MODIFY COLUMN idproductoDigital INT AUTO_INCREMENT;




CREATE TABLE keyPrductos (
    idkeyPrductos INT PRIMARY KEY,
    keyPrducto VARCHAR(45),
    productoDigital_idproductoDigital INT,
    productoDigital_categoriasProducto_idcategoriasProducto INT,
    FOREIGN KEY (productoDigital_idproductoDigital) REFERENCES productoDigital(idproductoDigital),
    FOREIGN KEY (productoDigital_categoriasProducto_idcategoriasProducto) REFERENCES categoriasProducto(idcategoriasProducto)
);

CREATE TABLE usuarios_has_productoDigital (
    usuarios_idusuarios INT,
    usuarios_roles_idroles INT,
    productoDigital_idproductoDigital INT,
    productoDigital_categoriasProducto_idcategoriasProducto INT,
    PRIMARY KEY (
        usuarios_idusuarios, 
        usuarios_roles_idroles, 
        productoDigital_idproductoDigital, 
        productoDigital_categoriasProducto_idcategoriasProducto
    ),
    FOREIGN KEY (usuarios_idusuarios) REFERENCES usuarios(idusuarios),
    FOREIGN KEY (usuarios_roles_idroles) REFERENCES roles(idroles),
    FOREIGN KEY (productoDigital_idproductoDigital) REFERENCES productoDigital(idproductoDigital),
    FOREIGN KEY (productoDigital_categoriasProducto_idcategoriasProducto) REFERENCES categoriasProducto(idcategoriasProducto)
);



-- Insertar datos en la tabla roles
INSERT INTO roles (idroles, nombreRol) VALUES
(1, 'root'),
(2, 'pasante'),
(3, 'usuario');

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (idusuarios, usuario, password, roles_idroles) VALUES
(1, 'admin', 'admin123', 1),
(2, 'developer', 'dev123', 2),
(3, 'gamer1', 'gamerpass1', 3),
(4, 'gamer2', 'gamerpass2', 3),
(5, 'gamer3', 'gamerpass3', 3),
(6, 'gamer4', 'gamerpass4', 3),
(7, 'tester', 'test123', 2),
(8, 'manager', 'manager123', 2),
(9, 'support', 'support123', 2),
(10, 'client1', 'clientpass1', 3);

-- Insertar datos en la tabla categoriasProducto
INSERT INTO categoriasProducto (idcategoriasProducto, nombreCategoria) VALUES
(1, 'RPG'),
(2, 'Shooter'),
(3, 'Adventure'),
(4, 'Horror'),
(5, 'Puzzle'),
(6, 'Platformer'),
(7, 'Sports'),
(8, 'Simulation'),
(9, 'Strategy'),
(10, 'Action');

-- Insertar datos en la tabla productoDigital
INSERT INTO productoDigital (idproductoDigital, tituloProducto, descripcionProducto, urlPortada, categoriasProducto_idcategorias) VALUES
(1, 'The Witcher 3', 'Epic RPG game', 'url1.jpg', 1),
(2, 'Call of Duty', 'Top Shooter', 'url2.jpg', 2),
(3, 'Zelda: Breath of the Wild', 'Adventure classic', 'url3.jpg', 3),
(4, 'Resident Evil', 'Survival horror', 'url4.jpg', 4),
(5, 'Portal 2', 'Best puzzle game', 'url5.jpg', 5),
(6, 'Super Mario Bros', 'Iconic platformer', 'url6.jpg', 6),
(7, 'FIFA 23', 'Popular sports game', 'url7.jpg', 7),
(8, 'The Sims 4', 'Life simulation', 'url8.jpg', 8),
(9, 'Civilization VI', 'Turn-based strategy', 'url9.jpg', 9),
(10, 'God of War', 'Action-packed adventure', 'url10.jpg', 10);

-- Insertar datos en la tabla keyPrductos
INSERT INTO keyPrductos (idkeyPrductos, keyPrducto, productoDigital_idproductoDigital, productoDigital_categoriasProducto_idcategoriasProducto) VALUES
(1, 'KEY123RPG', 1, 1),
(2, 'KEY456SHOOTER', 2, 2),
(3, 'KEY789ADVENTURE', 3, 3),
(4, 'KEY101HORROR', 4, 4),
(5, 'KEY112PUZZLE', 5, 5),
(6, 'KEY131PLATFORMER', 6, 6),
(7, 'KEY145SPORTS', 7, 7),
(8, 'KEY167SIMULATION', 8, 8),
(9, 'KEY189STRATEGY', 9, 9),
(10, 'KEY200ACTION', 10, 10);

-- Insertar datos en la tabla usuarios_has_productoDigital
INSERT INTO usuarios_has_productoDigital (usuarios_idusuarios, usuarios_roles_idroles, productoDigital_idproductoDigital, productoDigital_categoriasProducto_idcategoriasProducto) VALUES
(3, 3, 1, 1),
(4, 3, 2, 2),
(5, 3, 3, 3),
(6, 3, 4, 4),
(7, 2, 5, 5),
(8, 2, 6, 6),
(9, 2, 7, 7),
(10, 3, 8, 8),
(1, 1, 9, 9),
(2, 2, 10, 10);




SELECT * from usuarios JOIN roles ON usuarios.roles_idroles = roles.idroles WHERE usuarios.usuario = ? AND usuarios.password = ?




SELECT * from productodigital;



SELECT CLIENTES.codUsuarios, CLIENTES.nombre, CLIENTES.apellido, CLIENTES.usuario, CLIENTES.correo
                                    FROM CLIENTES
                                    WHERE CLIENTES.usuario LIKE ? OR CLIENTES.nombre LIKE ? OR CLIENTES.apellido LIKE ?


SELECT productodigital.idproductoDigital, productodigital.tituloProducto, productodigital.descripcionProducto, productodigital.urlPortada, categoriasproducto.nombreCategoria
FROM productodigital JOIN categoriasproducto ON productodigital.categoriasProducto_idcategorias = categoriasproducto.idcategoriasProducto;