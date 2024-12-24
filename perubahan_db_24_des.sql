ALTER TABLE product_details
    ALTER COLUMN price TYPE DECIMAL(15, 0),   -- Allows for prices up to 999 trillion with 2 decimal places
    ALTER COLUMN discount TYPE DECIMAL(15, 0); -- Allows for discount values as nominal amounts up to 999 trillion
