/*Create DB tables for photo print shop*/

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description VARCHAR(250) NULL,
  image_filename VARCHAR(250) NULL,
  base_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carts (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_carts_user
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE SET NULL
);

CREATE TABLE cart_items (
  cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
  cart_id INT NOT NULL,
  product_id INT NOT NULL,
  size VARCHAR(20) NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_cartitems_cart
    FOREIGN KEY (cart_id) REFERENCES carts(cart_id)
    ON DELETE CASCADE,
  CONSTRAINT fk_cartitems_product
    FOREIGN KEY (product_id) REFERENCES products(product_id)
    ON DELETE RESTRICT,
  CONSTRAINT uq_cart_product_size UNIQUE (cart_id, product_id, size)
);

/*Place holder products for images to be used*/

INSERT INTO products (title,description,image_filename,base_price)
VALUES
('wAp1','Wes Andy Collection','wa_01.jpeg',15.00),
('wAp2','Wes Andy Collection','wa_02.jpeg',15.00),
('wAp3','Wes Andy Collection','wa_03.jpeg',15.00),
('wAp4','Wes Andy Collection','wa_04.jpeg',15.00),
('wAp5','Wes Andy Collection','wa_05.jpeg',15.00),
('wAp6','Wes Andy Collection','wa_06.jpeg',15.00),
('wAp7','Wes Andy Collection','wa_07.jpeg',15.00),
('wAp8','Wes Andy Collection','wa_08.jpeg',15.00),
('wAp9','Wes Andy Collection','wa_09.jpeg',15.00),
('wAp10','Wes Andy Collection','wa_10.jpeg',15.00);