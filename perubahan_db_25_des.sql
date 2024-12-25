ALTER TABLE branches ADD CONSTRAINT unique_branch_code UNIQUE (code);
ALTER TABLE products ADD CONSTRAINT unique_product_code UNIQUE (code);


ALTER TABLE product_details
ADD CONSTRAINT product_branch_unique UNIQUE (product_id, branch_id);


ALTER TABLE product_details
ALTER COLUMN product_id SET NOT NULL,
ALTER COLUMN branch_id SET NOT NULL;
