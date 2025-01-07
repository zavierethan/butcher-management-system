CREATE TABLE suppliers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    address TEXT,
    is_active INT2 NULL,
    created_at TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP NULL,
    created_by VARCHAR(50) NULL,
    updated_at TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP NULL,
    updated_by VARCHAR(50) NULL
);
