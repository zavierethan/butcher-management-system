ALTER TABLE product_details
ALTER COLUMN branch_id DROP NOT NULL;

ALTER TABLE product_details
ALTER COLUMN price DROP NOT NULL;

ALTER TABLE product_details
ADD COLUMN is_active int2 DEFAULT 0;