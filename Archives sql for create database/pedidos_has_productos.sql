CREATE TABLE pedidos_has_productos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    unidades INT,
    
    
    CONSTRAINT FK_id_pedidos FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    CONSTRAINT FK_id_productos FOREIGN KEY (id_producto) REFERENCES productos(id_productos)
)