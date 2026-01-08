
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name  VARCHAR(50) NOT NULL,
  email      VARCHAR(255) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  title          VARCHAR(100) NOT NULL,
  description    VARCHAR(250) NULL,
  image_filename VARCHAR(250) NULL,
  base_price     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  max_quantity   INT NOT NULL DEFAULT 5
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
  cart_id    INT NOT NULL,
  product_id INT NOT NULL,
  size       VARCHAR(20) NOT NULL,
  qty        INT NOT NULL DEFAULT 1,
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


INSERT INTO products (title, description, image_filename, base_price, max_quantity) VALUES
('Pink Utility','A solitary pastel shed centered in open green space, blending suburban order with playful color contrast.','wes_andy_01.jpg',24.99,5),
('Park Maintenance','A neatly aligned tractor and equipment paused mid-task, emphasizing balance, color, and quiet routine.','wes_andy_02.jpg',24.99,5),
('Waiting Benches','Symmetrical turquoise swings beneath a clean beam, inviting stillness in a carefully framed public space.','wes_andy_03.jpg',24.99,5),
('Playground Exit','A bold yellow slide emerging from abstract playground forms, capturing geometry, color, and nostalgia.','wes_andy_04.jpg',24.99,5),
('Red Flag Day','A minimal beach scene marked by a single red flag, balancing calm horizons with subtle tension.','wes_andy_05.jpg',24.99,5),
('Parked Scooter','A mint-colored scooter resting among palms, evoking leisure, symmetry, and coastal quiet.','wes_andy_06.jpg',24.99,5),
('Sky Bloom','Delicate flowers reach into open sky, emphasizing scale, softness, and restrained color harmony.','wes_andy_07.jpg',24.99,5),
('Center Court','A lone basketball placed precisely on painted lines, highlighting order, balance, and everyday stillness.','wes_andy_08.jpg',24.99,5);
