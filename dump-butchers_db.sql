/*
 Navicat Premium Data Transfer

 Source Server         : Pryadis Butchers
 Source Server Type    : PostgreSQL
 Source Server Version : 160001 (160001)
 Source Host           : localhost:5432
 Source Catalog        : finance
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160001 (160001)
 File Encoding         : 65001

 Date: 19/12/2024 01:39:14
*/


-- ----------------------------
-- Sequence structure for branches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."branches_id_seq";
CREATE SEQUENCE "public"."branches_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for failed_jobs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."failed_jobs_id_seq";
CREATE SEQUENCE "public"."failed_jobs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for menus_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."menus_id_seq";
CREATE SEQUENCE "public"."menus_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for permissions_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."permissions_id_seq";
CREATE SEQUENCE "public"."permissions_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for personal_access_tokens_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."personal_access_tokens_id_seq";
CREATE SEQUENCE "public"."personal_access_tokens_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for product_categories_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."product_categories_id_seq";
CREATE SEQUENCE "public"."product_categories_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for product_categories_id_seq1
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."product_categories_id_seq1";
CREATE SEQUENCE "public"."product_categories_id_seq1" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for products_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."products_id_seq";
CREATE SEQUENCE "public"."products_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for role_menu_access_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."role_menu_access_id_seq";
CREATE SEQUENCE "public"."role_menu_access_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for transaction_code_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."transaction_code_sequence";
CREATE SEQUENCE "public"."transaction_code_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 99999
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for transaction_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."transaction_items_id_seq";
CREATE SEQUENCE "public"."transaction_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for transactions_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."transactions_id_seq";
CREATE SEQUENCE "public"."transactions_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for user_groups_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_groups_id_seq";
CREATE SEQUENCE "public"."user_groups_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for branches
-- ----------------------------
DROP TABLE IF EXISTS "public"."branches";
CREATE TABLE "public"."branches" (
  "id" int4 NOT NULL DEFAULT nextval('branches_id_seq'::regclass),
  "code" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "address" text COLLATE "pg_catalog"."default" NOT NULL,
  "is_active" int2,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "created_by" varchar(50) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_by" varchar(50) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of branches
-- ----------------------------
INSERT INTO "public"."branches" VALUES (1, '00001', 'PUSAT', '-', 1, '2024-12-17 23:42:39.921766', NULL, '2024-12-17 23:42:39.921766', NULL);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS "public"."customers";
CREATE TABLE "public"."customers" (
  "id" int4 NOT NULL,
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "ktp_number" varchar(50) COLLATE "pg_catalog"."default",
  "phone_number" varchar(20) COLLATE "pg_catalog"."default",
  "type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "is_active" int2,
  "created_by" varchar(50) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_by" varchar(50) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO "public"."customers" VALUES (1, 'Hendri', '0123456789', '0821333888777', 'Perorangan', 1, NULL, '2024-12-14 11:33:43.711089', NULL, '2024-12-14 11:33:43.711089');
INSERT INTO "public"."customers" VALUES (2, 'Satyaa', '099922278884328', '08215556667778', 'Perusahaan/Kolektif', 1, NULL, '2024-12-14 11:34:05.185507', NULL, '2024-12-14 11:34:05.185507');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS "public"."failed_jobs";
CREATE TABLE "public"."failed_jobs" (
  "id" int8 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
  "uuid" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "connection" text COLLATE "pg_catalog"."default" NOT NULL,
  "queue" text COLLATE "pg_catalog"."default" NOT NULL,
  "payload" text COLLATE "pg_catalog"."default" NOT NULL,
  "exception" text COLLATE "pg_catalog"."default" NOT NULL,
  "failed_at" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for group_menu_access
-- ----------------------------
DROP TABLE IF EXISTS "public"."group_menu_access";
CREATE TABLE "public"."group_menu_access" (
  "id" int4 NOT NULL DEFAULT nextval('role_menu_access_id_seq'::regclass),
  "group_id" int4,
  "menu_id" int4,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "can_view" int4,
  "can_edit" int4,
  "can_delete" int4
)
;

-- ----------------------------
-- Records of group_menu_access
-- ----------------------------
INSERT INTO "public"."group_menu_access" VALUES (82, 2, 26, '2024-12-10 14:42:46.230803', '2024-12-10 14:42:46.230803', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (83, 1, 27, '2024-12-10 19:26:16.391966', '2024-12-10 19:26:16.391966', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (84, 1, 28, '2024-12-10 19:26:19.080464', '2024-12-10 19:26:19.080464', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (85, 1, 29, '2024-12-10 19:26:22.718246', '2024-12-10 19:26:22.718246', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (86, 1, 30, '2024-12-10 19:26:25.426336', '2024-12-10 19:26:25.426336', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (87, 1, 31, '2024-12-10 19:26:27.486779', '2024-12-10 19:26:27.486779', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (88, 1, 32, '2024-12-10 19:26:29.333733', '2024-12-10 19:26:29.333733', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (89, 1, 33, '2024-12-10 19:26:31.248525', '2024-12-10 19:26:31.248525', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (90, 1, 34, '2024-12-10 19:26:33.28795', '2024-12-10 19:26:33.28795', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (91, 1, 35, '2024-12-10 19:26:35.207362', '2024-12-10 19:26:35.207362', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (92, 1, 36, '2024-12-10 19:26:38.047798', '2024-12-10 19:26:38.047798', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (93, 1, 37, '2024-12-10 19:26:40.383702', '2024-12-10 19:26:40.383702', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (94, 1, 38, '2024-12-14 11:30:19.39454', '2024-12-14 11:30:19.39454', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (95, 1, 39, '2024-12-15 13:42:36.721829', '2024-12-15 13:42:36.721829', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (96, 1, 40, '2024-12-15 13:42:40.295078', '2024-12-15 13:42:40.295078', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS "public"."groups";
CREATE TABLE "public"."groups" (
  "id" int8 NOT NULL DEFAULT nextval('user_groups_id_seq'::regclass),
  "code" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(100) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO "public"."groups" VALUES (1, 'G00001', 'SUPARADMIN', '2024-11-25 22:54:07', NULL);

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS "public"."menus";
CREATE TABLE "public"."menus" (
  "id" int4 NOT NULL DEFAULT nextval('menus_id_seq'::regclass),
  "parent_id" int4,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "url" varchar(255) COLLATE "pg_catalog"."default",
  "icon" varchar(255) COLLATE "pg_catalog"."default",
  "order" int4 NOT NULL DEFAULT 0,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "is_active" int2
)
;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO "public"."menus" VALUES (35, NULL, 'Master Data', NULL, '<i class="fa-solid fa-database"></i>', 4, '2024-12-10 19:24:52.034887', '2024-12-10 19:24:52.034887', 1);
INSERT INTO "public"."menus" VALUES (27, NULL, 'Dashboard', NULL, '<i class="fa-solid fa-chart-line"></i>', 1, '2024-12-10 19:20:41.346046', '2024-12-10 19:20:41.346046', 1);
INSERT INTO "public"."menus" VALUES (29, NULL, 'Transactions', NULL, '<i class="fa-solid fa-shop"></i>', 2, '2024-12-10 19:22:09.107133', '2024-12-10 19:22:09.107133', 1);
INSERT INTO "public"."menus" VALUES (28, 27, 'Default', 'home', NULL, 1, '2024-12-10 19:21:34.99048', '2024-12-10 19:21:34.99048', 1);
INSERT INTO "public"."menus" VALUES (30, 29, 'Point of Sales', 'transactions', '-', 1, '2024-12-10 19:22:40.225983', '2024-12-10 19:22:40.225983', 1);
INSERT INTO "public"."menus" VALUES (32, 31, 'Users', 'users', '-', 1, '2024-12-10 19:23:23.245531', '2024-12-10 19:23:23.245531', 1);
INSERT INTO "public"."menus" VALUES (33, 31, 'Groups', 'groups', '-', 2, '2024-12-10 19:23:43.072009', '2024-12-10 19:23:43.072009', 1);
INSERT INTO "public"."menus" VALUES (34, 31, 'Menus', 'menus', '-', 3, '2024-12-10 19:24:06.927427', '2024-12-10 19:24:06.927427', 1);
INSERT INTO "public"."menus" VALUES (36, 35, 'Products', 'products', '-', 1, '2024-12-10 19:25:19.137683', '2024-12-10 19:25:19.137683', 1);
INSERT INTO "public"."menus" VALUES (37, 35, 'Branches (Outlets)', 'branches', '-', 2, '2024-12-10 19:25:57.012285', '2024-12-10 19:25:57.012285', 1);
INSERT INTO "public"."menus" VALUES (31, NULL, 'Account', NULL, '<i class="fa-solid fa-user-gear"></i>', 3, '2024-12-10 19:23:04.127476', '2024-12-10 19:23:04.127476', 1);
INSERT INTO "public"."menus" VALUES (38, 29, 'Order Lists', 'orders', '-', 2, '2024-12-14 11:30:04.747337', '2024-12-14 11:30:04.747337', 1);
INSERT INTO "public"."menus" VALUES (39, 35, 'Product Categories', 'product-categories', '-', 2, '2024-12-15 13:41:48.501771', '2024-12-15 13:41:48.501771', 1);
INSERT INTO "public"."menus" VALUES (40, 35, 'Customers', 'customers', '-', 4, '2024-12-15 13:42:22.216152', '2024-12-15 13:42:22.216152', 1);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
  "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  "migration" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "batch" int4 NOT NULL
)
;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO "public"."migrations" VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO "public"."migrations" VALUES (3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO "public"."migrations" VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO "public"."migrations" VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO "public"."migrations" VALUES (6, '2024_09_29_112508_create_user_groups_table', 1);
INSERT INTO "public"."migrations" VALUES (7, '2024_09_29_113257_create_permissions_table', 2);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_reset_tokens";
CREATE TABLE "public"."password_reset_tokens" (
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0)
)
;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_resets";
CREATE TABLE "public"."password_resets" (
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0)
)
;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS "public"."permissions";
CREATE TABLE "public"."permissions" (
  "id" int8 NOT NULL DEFAULT nextval('permissions_id_seq'::regclass),
  "desc" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."personal_access_tokens";
CREATE TABLE "public"."personal_access_tokens" (
  "id" int8 NOT NULL DEFAULT nextval('personal_access_tokens_id_seq'::regclass),
  "tokenable_type" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tokenable_id" int8 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "abilities" text COLLATE "pg_catalog"."default",
  "last_used_at" timestamp(0),
  "expires_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product_categories
-- ----------------------------
DROP TABLE IF EXISTS "public"."product_categories";
CREATE TABLE "public"."product_categories" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1
),
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "is_active" int2,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "created_by" varchar(50) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_by" varchar(50) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of product_categories
-- ----------------------------
INSERT INTO "public"."product_categories" VALUES (1, 'Fillet', 1, '2024-12-14 11:58:48.488357', NULL, '2024-12-14 11:58:48.488357', NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS "public"."products";
CREATE TABLE "public"."products" (
  "id" int4 NOT NULL DEFAULT nextval('products_id_seq'::regclass),
  "code" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "price" numeric(10,2) NOT NULL,
  "is_active" int2,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "created_by" varchar(50) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_by" varchar(50) COLLATE "pg_catalog"."default",
  "url_path" varchar(255) COLLATE "pg_catalog"."default",
  "category_id" int4 NOT NULL
)
;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO "public"."products" VALUES (1, 'KKS', 'KARKAS', 29000.00, 1, '2024-12-14 11:38:25.642056', NULL, '2024-12-14 11:38:25.642056', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (2, 'DD', 'DADA', 29000.00, 1, '2024-12-14 11:39:01.533187', NULL, '2024-12-14 11:39:01.533187', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (3, 'PH', 'PAHA', 29000.00, 1, '2024-12-14 11:39:24.162423', NULL, '2024-12-14 11:39:24.162423', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (4, 'PHA', 'PAHA ATAS', 29000.00, 1, '2024-12-14 11:39:43.477635', NULL, '2024-12-14 11:39:43.477635', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (5, 'PHP', 'PAHA PENTUL', 31000.00, 1, '2024-12-14 11:40:03.270331', NULL, '2024-12-14 11:40:03.270331', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (6, 'SY', 'SAYAP', 30000.00, 1, '2024-12-14 11:40:22.926672', NULL, '2024-12-14 11:40:22.926672', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (7, 'KL', 'KULIT', 26000.00, 1, '2024-12-14 11:40:43.02812', NULL, '2024-12-14 11:40:43.02812', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (8, 'TRO', 'TULANG RONGKONG', 12000.00, 1, '2024-12-14 11:41:04.246605', NULL, '2024-12-14 11:41:04.246605', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (9, 'TSP', 'TULANG SUPER', 20000.00, 1, '2024-12-14 11:41:22.24867', NULL, '2024-12-14 11:41:22.24867', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (10, 'TRW', 'TULANG RAWAN', 50000.00, 1, '2024-12-14 11:41:41.622482', NULL, '2024-12-14 11:41:41.622482', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (11, 'TPH', 'TULANG PAHA', 10000.00, 1, '2024-12-14 11:42:00.242787', NULL, '2024-12-14 11:42:00.242787', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (12, 'TTLN', 'TETELAN', 22000.00, 1, '2024-12-14 11:42:18.713105', NULL, '2024-12-14 11:42:18.713105', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (13, 'FDK', 'FILLET DADA KULIT', 39000.00, 1, '2024-12-14 11:42:38.54021', NULL, '2024-12-14 11:42:38.54021', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (14, 'FDB', 'FILLET DADA BERSIH', 41000.00, 1, '2024-12-14 11:42:57.489507', NULL, '2024-12-14 11:42:57.489507', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (15, 'FPK', 'FILLET PAHA KULIT', 39000.00, 1, '2024-12-14 11:43:18.947709', NULL, '2024-12-14 11:43:18.947709', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (16, 'FPB', 'FILLET PAHA BERSIH', 41000.00, 1, '2024-12-14 11:43:38.416677', NULL, '2024-12-14 11:43:38.416677', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (17, 'DGL', 'DAGING AYAM GILING', 45000.00, 1, '2024-12-14 11:43:55.90923', NULL, '2024-12-14 11:43:55.90923', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (18, 'AA', 'ATI AMPELA', 20000.00, 1, '2024-12-14 11:44:30.77473', NULL, '2024-12-14 11:44:30.77473', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (19, 'US', 'USUS', 20000.00, 1, '2024-12-14 11:44:52.210784', NULL, '2024-12-14 11:44:52.210784', NULL, NULL, 1);
INSERT INTO "public"."products" VALUES (23, 'X001', 'Wings', 24000.00, 1, '2024-12-17 19:05:19.441752', NULL, '2024-12-17 19:05:19.441752', NULL, 'products/RLpSxtyPVicgZkCp5J4UneCh7FDGjs6rluKd8ajd.jpg', 1);
INSERT INTO "public"."products" VALUES (22, 'TLR', 'TELUR', 27000.00, 1, '2024-12-14 11:45:50.653122', NULL, '2024-12-14 11:45:50.653122', NULL, 'products/cpirtkJO4dNNNLbriA55h0HByFTAEpWBcEFsUqjn.jpg', 1);
INSERT INTO "public"."products" VALUES (21, 'CKR', 'CEKER', 24000.00, 1, '2024-12-14 11:45:29.613916', NULL, '2024-12-14 11:45:29.613916', NULL, 'products/RGJXSYczqjYCjsqvDnWzKlq01bHWO9UHTC3Y3cSE.jpg', 1);
INSERT INTO "public"."products" VALUES (20, 'KPL', 'KEPALA', 13000.00, 1, '2024-12-14 11:45:10.308158', NULL, '2024-12-14 11:45:10.308158', NULL, 'products/jO5N4SmazKszNBx3ytCaGtZPV0jeXSGpHgkSccuH.png', 1);

-- ----------------------------
-- Table structure for transaction_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."transaction_items";
CREATE TABLE "public"."transaction_items" (
  "id" int4 NOT NULL DEFAULT nextval('transaction_items_id_seq'::regclass),
  "transaction_id" int4,
  "product_id" int4,
  "quantity" numeric(10,1),
  "unit_price" numeric(10,0),
  "base_price" numeric(10,0)
)
;

-- ----------------------------
-- Records of transaction_items
-- ----------------------------
INSERT INTO "public"."transaction_items" VALUES (43, 16, 4, 5.0, 145000, 29000);
INSERT INTO "public"."transaction_items" VALUES (44, 17, 5, 1.0, 31000, 31000);
INSERT INTO "public"."transaction_items" VALUES (45, 17, 6, 1.0, 30000, 30000);
INSERT INTO "public"."transaction_items" VALUES (46, 17, 9, 1.0, 20000, 20000);
INSERT INTO "public"."transaction_items" VALUES (47, 18, 5, 1.0, 31000, 31000);
INSERT INTO "public"."transaction_items" VALUES (48, 18, 6, 1.0, 30000, 30000);
INSERT INTO "public"."transaction_items" VALUES (49, 19, 5, 1.0, 31000, 31000);
INSERT INTO "public"."transaction_items" VALUES (50, 19, 6, 1.0, 30000, 30000);
INSERT INTO "public"."transaction_items" VALUES (51, 19, 9, 1.0, 20000, 20000);
INSERT INTO "public"."transaction_items" VALUES (52, 20, 1, 2.0, 43500, 29000);
INSERT INTO "public"."transaction_items" VALUES (53, 20, 2, 6.0, 159500, 29000);
INSERT INTO "public"."transaction_items" VALUES (54, 20, 3, 10.0, 290000, 29000);
INSERT INTO "public"."transaction_items" VALUES (60, 21, 11, 1.0, 10000, 10000);
INSERT INTO "public"."transaction_items" VALUES (61, 21, 10, 1.0, 50000, 50000);
INSERT INTO "public"."transaction_items" VALUES (62, 21, 13, 1.0, 39000, 39000);
INSERT INTO "public"."transaction_items" VALUES (63, 21, 14, 1.0, 41000, 41000);
INSERT INTO "public"."transaction_items" VALUES (65, 22, 1, 1.0, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (66, 22, 2, 1.0, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (67, 22, 4, 1.0, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (69, 22, 6, 1.0, 30000, 30000);
INSERT INTO "public"."transaction_items" VALUES (55, 21, 1, 2.0, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (56, 21, 2, 1.2, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (57, 21, 5, 1.2, 31000, 31000);
INSERT INTO "public"."transaction_items" VALUES (58, 21, 4, 1.2, 29000, 29000);
INSERT INTO "public"."transaction_items" VALUES (59, 21, 6, 1.0, 30000, 30000);
INSERT INTO "public"."transaction_items" VALUES (41, 16, 1, 2.2, 43500, 29000);
INSERT INTO "public"."transaction_items" VALUES (68, 22, 5, 1.5, 31000, 31000);
INSERT INTO "public"."transaction_items" VALUES (42, 16, 3, 2.2, 101500, 29000);
INSERT INTO "public"."transaction_items" VALUES (64, 21, 15, 2.8, 39000, 39000);
INSERT INTO "public"."transaction_items" VALUES (70, 23, 18, 1.5, 30000, 20000);

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS "public"."transactions";
CREATE TABLE "public"."transactions" (
  "id" int4 NOT NULL DEFAULT nextval('transactions_id_seq'::regclass),
  "transaction_date" timestamp(6),
  "customer_id" int4,
  "total_amount" numeric(10,0) NOT NULL,
  "payment_method" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "status" int4,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "code" varchar(50) COLLATE "pg_catalog"."default",
  "created_by" int4,
  "discount" numeric(10,2) DEFAULT 0
)
;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO "public"."transactions" VALUES (16, '2024-12-15 00:00:00', 1, 290000, '2', 2, '2024-12-15 23:09:18.998152', '20241200011', 2, NULL);
INSERT INTO "public"."transactions" VALUES (17, '2024-12-15 00:00:00', 1, 81000, '1', 3, '2024-12-15 23:17:46.599889', '20241200015', 2, NULL);
INSERT INTO "public"."transactions" VALUES (18, '2024-12-15 00:00:00', 1, 61000, '3', 3, '2024-12-15 23:18:02.682909', '20241200016', 2, NULL);
INSERT INTO "public"."transactions" VALUES (19, '2024-12-15 00:00:00', 1, 81000, '2', 3, '2024-12-15 23:19:23.001563', '20241200018', 2, NULL);
INSERT INTO "public"."transactions" VALUES (20, '2024-12-15 00:00:00', 1, 493000, '1', 3, '2024-12-15 23:31:06.896949', '20241200019', 2, NULL);
INSERT INTO "public"."transactions" VALUES (21, '2024-12-15 00:00:00', 1, 327000, '1', 1, '2024-12-15 23:32:54.958939', '20241200020', 2, NULL);
INSERT INTO "public"."transactions" VALUES (22, '2024-12-15 00:00:00', 1, 148000, '4', 1, '2024-12-15 23:45:15.405365', '20241200021', 2, NULL);
INSERT INTO "public"."transactions" VALUES (23, '2024-12-18 00:00:00', 1, 30000, '1', 1, '2024-12-19 01:21:35.534013', '20241200022', 2, 0.00);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email_verified_at" timestamp(0),
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "remember_token" varchar(100) COLLATE "pg_catalog"."default",
  "group_id" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "is_active" int2,
  "branch_id" int4
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES (2, 'admin', 'admin@gmail.com', NULL, '$2y$10$5IFbNv.tVM0j66nhHQsaz.PbMYBYZcnKWeYUT022WJSkCuvT0M0TK', NULL, 1, '2024-11-23 04:36:01', '2024-11-27 10:17:36', 1, 1);

-- ----------------------------
-- Function structure for generate_transaction_code
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."generate_transaction_code"();
CREATE OR REPLACE FUNCTION "public"."generate_transaction_code"()
  RETURNS "pg_catalog"."text" AS $BODY$
DECLARE
    current_year TEXT;
    current_month TEXT;
    new_sequence INTEGER;
    padded_sequence TEXT;
BEGIN
    -- Get the current year and month
    current_year := TO_CHAR(NOW(), 'YYYY');  -- Current year (YYYY)
    current_month := TO_CHAR(NOW(), 'MM');   -- Current month (MM)
    
    -- Get the next value from the sequence
    new_sequence := nextval('transaction_code_sequence');
    
    -- Format the sequence number as a 5-digit string (pad with leading zeros)
    padded_sequence := LPAD(new_sequence::TEXT, 5, '0');

    -- Generate the final transaction code
    RETURN current_year || current_month || padded_sequence;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."branches_id_seq"
OWNED BY "public"."branches"."id";
SELECT setval('"public"."branches_id_seq"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."failed_jobs_id_seq"
OWNED BY "public"."failed_jobs"."id";
SELECT setval('"public"."failed_jobs_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."menus_id_seq"
OWNED BY "public"."menus"."id";
SELECT setval('"public"."menus_id_seq"', 40, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."migrations_id_seq"
OWNED BY "public"."migrations"."id";
SELECT setval('"public"."migrations_id_seq"', 7, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."permissions_id_seq"
OWNED BY "public"."permissions"."id";
SELECT setval('"public"."permissions_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."personal_access_tokens_id_seq"
OWNED BY "public"."personal_access_tokens"."id";
SELECT setval('"public"."personal_access_tokens_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."product_categories_id_seq"
OWNED BY "public"."product_categories"."id";
SELECT setval('"public"."product_categories_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."product_categories_id_seq1"
OWNED BY "public"."product_categories"."id";
SELECT setval('"public"."product_categories_id_seq1"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."products_id_seq"
OWNED BY "public"."products"."id";
SELECT setval('"public"."products_id_seq"', 23, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."role_menu_access_id_seq"
OWNED BY "public"."group_menu_access"."id";
SELECT setval('"public"."role_menu_access_id_seq"', 96, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."transaction_code_sequence"', 22, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."transaction_items_id_seq"
OWNED BY "public"."transaction_items"."id";
SELECT setval('"public"."transaction_items_id_seq"', 70, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."transactions_id_seq"
OWNED BY "public"."transactions"."id";
SELECT setval('"public"."transactions_id_seq"', 23, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_groups_id_seq"
OWNED BY "public"."groups"."id";
SELECT setval('"public"."user_groups_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_id_seq"
OWNED BY "public"."users"."id";
SELECT setval('"public"."users_id_seq"', 1105, true);

-- ----------------------------
-- Primary Key structure for table branches
-- ----------------------------
ALTER TABLE "public"."branches" ADD CONSTRAINT "branches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid");

-- ----------------------------
-- Primary Key structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table group_menu_access
-- ----------------------------
ALTER TABLE "public"."group_menu_access" ADD CONSTRAINT "role_menu_access_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table groups
-- ----------------------------
ALTER TABLE "public"."groups" ADD CONSTRAINT "user_groups_pkey" PRIMARY KEY ("id", "code");

-- ----------------------------
-- Primary Key structure for table menus
-- ----------------------------
ALTER TABLE "public"."menus" ADD CONSTRAINT "menus_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table password_reset_tokens
-- ----------------------------
ALTER TABLE "public"."password_reset_tokens" ADD CONSTRAINT "password_reset_tokens_pkey" PRIMARY KEY ("email");

-- ----------------------------
-- Indexes structure for table password_resets
-- ----------------------------
CREATE INDEX "password_resets_email_index" ON "public"."password_resets" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table permissions
-- ----------------------------
ALTER TABLE "public"."permissions" ADD CONSTRAINT "permissions_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table personal_access_tokens
-- ----------------------------
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" ON "public"."personal_access_tokens" USING btree (
  "tokenable_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "tokenable_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "public"."personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_token_unique" UNIQUE ("token");

-- ----------------------------
-- Primary Key structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "public"."personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for product_categories
-- ----------------------------
SELECT setval('"public"."product_categories_id_seq1"', 1, true);

-- ----------------------------
-- Primary Key structure for table product_categories
-- ----------------------------
ALTER TABLE "public"."product_categories" ADD CONSTRAINT "product_categories_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Checks structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CONSTRAINT "products_price_check" CHECK (price >= 0::numeric);

-- ----------------------------
-- Primary Key structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CONSTRAINT "products_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table transaction_items
-- ----------------------------
ALTER TABLE "public"."transaction_items" ADD CONSTRAINT "transaction_items_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table transactions
-- ----------------------------
ALTER TABLE "public"."transactions" ADD CONSTRAINT "transactions_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_email_unique" UNIQUE ("email");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table menus
-- ----------------------------
ALTER TABLE "public"."menus" ADD CONSTRAINT "menus_parent_id_fkey" FOREIGN KEY ("parent_id") REFERENCES "public"."menus" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CONSTRAINT "fk_category" FOREIGN KEY ("category_id") REFERENCES "public"."product_categories" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table transaction_items
-- ----------------------------
ALTER TABLE "public"."transaction_items" ADD CONSTRAINT "transaction_items_product_id_fkey" FOREIGN KEY ("product_id") REFERENCES "public"."products" ("id") ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE "public"."transaction_items" ADD CONSTRAINT "transaction_items_transaction_id_fkey" FOREIGN KEY ("transaction_id") REFERENCES "public"."transactions" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
