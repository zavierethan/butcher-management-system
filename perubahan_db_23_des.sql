ALTER TABLE public.customers ALTER COLUMN id SET DEFAULT nextval('customers_id_seq'::regclass);

ALTER TABLE customers ALTER COLUMN id SET NOT NULL;
ALTER TABLE customers ADD CONSTRAINT customer_unique_id UNIQUE (id);

ALTER TABLE product_categories ADD CONSTRAINT product_categories_unique_id UNIQUE (id);

CREATE TABLE product_details (
    id SERIAL PRIMARY KEY,                  -- Unique identifier for each row
    product_id INT NOT NULL,                -- Foreign key to the products table
    price DECIMAL(10, 2) NOT NULL,          -- Product price with two decimal places
    branch_id INT,                          -- Foreign key to the branches table
    discount DECIMAL(5, 2),                 -- Discount percentage or value
    start_period DATE,                      -- Start date of the period
    end_period DATE,                        -- End date of the period
    created_by VARCHAR(255),                -- Identifier of the creator (e.g., username)
    created_at TIMESTAMP DEFAULT NOW(),     -- Timestamp of when the row was created
    updated_by VARCHAR(255),                -- Identifier of the last user who updated the record
    updated_at TIMESTAMP DEFAULT NOW(),     -- Timestamp of when the record was last updated
    CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    CONSTRAINT fk_branch_id FOREIGN KEY (branch_id) REFERENCES branches (id) ON DELETE SET NULL
);

ALTER TABLE products
DROP COLUMN price;

CREATE TABLE stocks (
    id SERIAL PRIMARY KEY,                  -- Unique identifier for each row
    product_id INT NOT NULL,                -- Foreign key to the products table
    quantity INT NOT NULL,                  -- Quantity of the product in stock
    branch_id INT,                          -- Foreign key to the branches table
    CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    CONSTRAINT fk_branch_id FOREIGN KEY (branch_id) REFERENCES branches (id) ON DELETE SET NULL
);

CREATE TABLE stock_logs (
    id SERIAL PRIMARY KEY,                  -- Unique identifier for each log entry
    stock_id INT NOT NULL,                   -- Foreign key to the stocks table
    in_quantity INT DEFAULT 0,               -- Quantity added to stock
    out_quantity INT DEFAULT 0,              -- Quantity removed from stock
    date TIMESTAMP DEFAULT NOW(),            -- Date and time of the log entry
    reference VARCHAR(255),                  -- Reference for the transaction (e.g., order number)
    CONSTRAINT fk_stock_id FOREIGN KEY (stock_id) REFERENCES stocks (id) ON DELETE RESTRICT
);

