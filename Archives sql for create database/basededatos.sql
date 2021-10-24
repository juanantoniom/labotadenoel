CREATE table cuenta_usuario(
    id_usuario INT AUTO_INCREMENT,
    nombre_usuario VARCHAR(45) NOT NULL,	
    email VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol VARCHAR(45)NOT NULL,
    
    CONSTRAINT PK_id_usuario PRIMARY KEY (id_usuario)
    
    
    )ENGINE=InnoDb;


CREATE TABLE usuario_info(
    id_usuarioInfo int AUTO_INCREMENT,
    nombre varchar(50),
    apellido varchar(50),
    direccion varchar(100),
    localidad varchar(100),
    provincia varchar(100),
    codigo_postal int(10),
    telefono int(30),
    telefono_movil int(30),
    id_usuario int,
    CONSTRAINT PK_id_usuarioInfo PRIMARY KEY (id_usuarioInfo),
    CONSTRAINT FK_id_usuario FOREIGN KEY (id_usuario) REFERENCES cuenta_usuario (id_usuario) ON DELETE CASCADE --le agregamos esto para poder borrar un usuario_info cuando borremos una cuenta de usuario primero	
    
    
    )ENGINE=InnoDb;


CREATE TABLE pedidos(

	id_pedido INT AUTO_INCREMENT PRIMARY KEY,
	fecha	  DATE,
        hora TIME,
	coste DECIMAL(6,2),
	id_usuarioInfo INT,
	CONSTRAINT FK_usuario_info FOREIGN KEY (id_usuarioInfo) REFERENCES usuario_info (id_usuarioInfo)

  )ENGINE=InnoDb;





CREATE TABLE categoria(
	
	categoria_id INT AUTO_INCREMENT,
	nombre_categoria VARCHAR(255),

	CONSTRAINT PK_categoria_id PRIMARY KEY (categoria_id)
	
)ENGINE=InnoDb;


CREATE TABLE productos(
	
	id_productos INT AUTO_INCREMENT,
	nombre VARCHAR(45),
	descripcion TEXT,
	precio DECIMAL(6,2),
	stock TINYINT,
	fecha DATE,
	imagen BLOB,
	categoria_id INT NOT NULL,
	CONSTRAINT PK_id_productos PRIMARY KEY (id_productos),
	CONSTRAINT FK_categoria_id FOREIGN KEY (categoria_id) REFERENCES categoria(categoria_id)

	


)ENGINE=InnoDb;