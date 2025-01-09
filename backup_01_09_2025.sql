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

 Date: 09/01/2025 20:58:13
*/


-- ----------------------------
-- Sequence structure for branch_sequences_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."branch_sequences_id_seq";
CREATE SEQUENCE "public"."branch_sequences_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

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
-- Sequence structure for chart_of_accounts_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."chart_of_accounts_id_seq";
CREATE SEQUENCE "public"."chart_of_accounts_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for customers_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."customers_id_seq";
CREATE SEQUENCE "public"."customers_id_seq" 
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
-- Sequence structure for goods_received_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."goods_received_id_seq";
CREATE SEQUENCE "public"."goods_received_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for goods_received_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."goods_received_items_id_seq";
CREATE SEQUENCE "public"."goods_received_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
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
-- Sequence structure for product_details_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."product_details_id_seq";
CREATE SEQUENCE "public"."product_details_id_seq" 
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
-- Sequence structure for purchase_order_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_order_items_id_seq";
CREATE SEQUENCE "public"."purchase_order_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for purchase_order_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_order_sequence";
CREATE SEQUENCE "public"."purchase_order_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 99999
START 1
CACHE 1
CYCLE ;

-- ----------------------------
-- Sequence structure for purchase_orders_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_orders_id_seq";
CREATE SEQUENCE "public"."purchase_orders_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for purchase_request_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_request_items_id_seq";
CREATE SEQUENCE "public"."purchase_request_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for purchase_request_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_request_sequence";
CREATE SEQUENCE "public"."purchase_request_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 99999
START 1
CACHE 1
CYCLE ;

-- ----------------------------
-- Sequence structure for purchase_requests_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_requests_id_seq";
CREATE SEQUENCE "public"."purchase_requests_id_seq" 
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
-- Sequence structure for stock_logs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."stock_logs_id_seq";
CREATE SEQUENCE "public"."stock_logs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for stocks_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."stocks_id_seq";
CREATE SEQUENCE "public"."stocks_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for suppliers_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."suppliers_id_seq";
CREATE SEQUENCE "public"."suppliers_id_seq" 
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
-- Table structure for branch_sequences
-- ----------------------------
DROP TABLE IF EXISTS "public"."branch_sequences";
CREATE TABLE "public"."branch_sequences" (
  "id" int4 NOT NULL DEFAULT nextval('branch_sequences_id_seq'::regclass),
  "branch_code" text COLLATE "pg_catalog"."default" NOT NULL,
  "current_sequence" int4 DEFAULT 0,
  "updated_at" timestamp(6) DEFAULT now()
)
;

-- ----------------------------
-- Records of branch_sequences
-- ----------------------------

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
  "updated_by" varchar(50) COLLATE "pg_catalog"."default",
  "phone_number" varchar(50) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of branches
-- ----------------------------
INSERT INTO "public"."branches" VALUES (4, 'P1', 'store1', '-', 1, '2025-01-09 20:20:58.331083', NULL, '2025-01-09 20:20:58.331083', NULL, '08991848066');
INSERT INTO "public"."branches" VALUES (5, 'P2', 'store2', '-', 1, '2025-01-09 20:21:22.24767', NULL, '2025-01-09 20:21:22.24767', NULL, '082117959982');

-- ----------------------------
-- Table structure for chart_of_accounts
-- ----------------------------
DROP TABLE IF EXISTS "public"."chart_of_accounts";
CREATE TABLE "public"."chart_of_accounts" (
  "id" int4 NOT NULL DEFAULT nextval('chart_of_accounts_id_seq'::regclass),
  "code" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "type" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "category" int4
)
;

-- ----------------------------
-- Records of chart_of_accounts
-- ----------------------------
INSERT INTO "public"."chart_of_accounts" VALUES (2, '101', 'Kas', 'debit', 1);
INSERT INTO "public"."chart_of_accounts" VALUES (3, '102', 'Piutang Usaha', 'debit', 1);
INSERT INTO "public"."chart_of_accounts" VALUES (4, '103', 'Persediaan Ayam Utuh', 'debit', 1);
INSERT INTO "public"."chart_of_accounts" VALUES (5, '104', 'Persediaan Ayam Potong', 'debit', 1);
INSERT INTO "public"."chart_of_accounts" VALUES (6, '201', 'Utang Usaha', 'kredit', 2);
INSERT INTO "public"."chart_of_accounts" VALUES (7, '202', 'Utang Pajak', 'kredit', 2);
INSERT INTO "public"."chart_of_accounts" VALUES (8, '301', 'Modal Pemilik', 'kredit', 3);
INSERT INTO "public"."chart_of_accounts" VALUES (9, '302', 'Laba Ditahan', 'kredit', 3);
INSERT INTO "public"."chart_of_accounts" VALUES (10, '401', 'Pendapatan Penjualan Ayam Potong', 'kredit', 4);
INSERT INTO "public"."chart_of_accounts" VALUES (11, '402', 'Pendapatan Lain', 'kredit', 4);
INSERT INTO "public"."chart_of_accounts" VALUES (12, '501', 'Beban Pembelian Ayam Utuh', 'debit', 5);
INSERT INTO "public"."chart_of_accounts" VALUES (13, '502', 'Beban Produksi', 'debit', 5);
INSERT INTO "public"."chart_of_accounts" VALUES (14, '503', 'Beban Operasional', 'debit', 5);
INSERT INTO "public"."chart_of_accounts" VALUES (15, '504', 'Beban Pajak', 'debit', 5);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS "public"."customers";
CREATE TABLE "public"."customers" (
  "id" int4 NOT NULL DEFAULT nextval('customers_id_seq'::regclass),
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "ktp_number" varchar(50) COLLATE "pg_catalog"."default",
  "phone_number" varchar(20) COLLATE "pg_catalog"."default",
  "type" varchar(50) COLLATE "pg_catalog"."default",
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
INSERT INTO "public"."customers" VALUES (2, 'Jhon Due', NULL, '082117283929', NULL, NULL, NULL, '2024-12-20 00:44:49.716807', NULL, '2024-12-20 00:44:49.716807');
INSERT INTO "public"."customers" VALUES (3, 'Nurpip', NULL, '983839393', NULL, NULL, NULL, '2024-12-20 00:47:20.723967', NULL, '2024-12-20 00:47:20.723967');
INSERT INTO "public"."customers" VALUES (4, 'Joko', NULL, '983839393', NULL, NULL, NULL, '2024-12-20 00:47:38.077716', NULL, '2024-12-20 00:47:38.077716');
INSERT INTO "public"."customers" VALUES (5, 'Naufal', NULL, '9839393092', NULL, NULL, NULL, '2024-12-20 00:50:23.287281', NULL, '2024-12-20 00:50:23.287281');
INSERT INTO "public"."customers" VALUES (6, 'Azka Korbuzier', NULL, '0821526272', NULL, NULL, NULL, '2024-12-20 01:01:53.09236', NULL, '2024-12-20 01:01:53.09236');
INSERT INTO "public"."customers" VALUES (7, 'Jhon Dalton', NULL, '983839393', NULL, NULL, NULL, '2025-01-06 08:21:31.277926', NULL, '2025-01-06 08:21:31.277926');

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
-- Table structure for goods_received
-- ----------------------------
DROP TABLE IF EXISTS "public"."goods_received";
CREATE TABLE "public"."goods_received" (
  "id" int4 NOT NULL DEFAULT nextval('goods_received_id_seq'::regclass),
  "purchase_order_id" int4 NOT NULL,
  "received_date" date NOT NULL,
  "status" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "received_by" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of goods_received
-- ----------------------------

-- ----------------------------
-- Table structure for goods_received_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."goods_received_items";
CREATE TABLE "public"."goods_received_items" (
  "id" int4 NOT NULL DEFAULT nextval('goods_received_items_id_seq'::regclass),
  "goods_received_id" int4 NOT NULL,
  "item_id" int4 NOT NULL,
  "quantity_received" int4 NOT NULL
)
;

-- ----------------------------
-- Records of goods_received_items
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
INSERT INTO "public"."group_menu_access" VALUES (126, 1, 54, '2025-01-09 19:51:28.433244', '2025-01-09 19:51:28.433244', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (127, 1, 55, '2025-01-09 19:51:31.903599', '2025-01-09 19:51:31.903599', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (128, 1, 56, '2025-01-09 19:51:34.962129', '2025-01-09 19:51:34.962129', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (129, 1, 57, '2025-01-09 19:51:36.839888', '2025-01-09 19:51:36.839888', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (130, 1, 58, '2025-01-09 19:51:38.420235', '2025-01-09 19:51:38.420235', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (131, 1, 59, '2025-01-09 19:51:41.038248', '2025-01-09 19:51:41.038248', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (132, 1, 60, '2025-01-09 19:51:42.595125', '2025-01-09 19:51:42.595125', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (133, 1, 61, '2025-01-09 20:09:39.693636', '2025-01-09 20:09:39.693636', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (134, 1, 62, '2025-01-09 20:09:41.47744', '2025-01-09 20:09:41.47744', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (135, 1, 63, '2025-01-09 20:09:43.367973', '2025-01-09 20:09:43.367973', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (136, 1, 64, '2025-01-09 20:09:44.99625', '2025-01-09 20:09:44.99625', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (137, 1, 65, '2025-01-09 20:09:47.323866', '2025-01-09 20:09:47.323866', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (138, 1, 66, '2025-01-09 20:09:49.741814', '2025-01-09 20:09:49.741814', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (139, 1, 67, '2025-01-09 20:09:52.248997', '2025-01-09 20:09:52.248997', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (140, 1, 68, '2025-01-09 20:09:54.270185', '2025-01-09 20:09:54.270185', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (141, 1, 69, '2025-01-09 20:09:57.239005', '2025-01-09 20:09:57.239005', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (142, 1, 70, '2025-01-09 20:09:59.406642', '2025-01-09 20:09:59.406642', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (143, 1, 71, '2025-01-09 20:10:01.473178', '2025-01-09 20:10:01.473178', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (144, 1, 72, '2025-01-09 20:10:03.074739', '2025-01-09 20:10:03.074739', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (145, 1, 73, '2025-01-09 20:10:05.951332', '2025-01-09 20:10:05.951332', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (146, 1, 74, '2025-01-09 20:10:07.286615', '2025-01-09 20:10:07.286615', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (147, 1, 75, '2025-01-09 20:10:10.387754', '2025-01-09 20:10:10.387754', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (148, 1, 76, '2025-01-09 20:10:13.36334', '2025-01-09 20:10:13.36334', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (149, 1, 77, '2025-01-09 20:10:16.189462', '2025-01-09 20:10:16.189462', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (150, 1, 78, '2025-01-09 20:10:18.649518', '2025-01-09 20:10:18.649518', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (151, 1, 79, '2025-01-09 20:10:20.527453', '2025-01-09 20:10:20.527453', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (152, 1, 80, '2025-01-09 20:10:21.837109', '2025-01-09 20:10:21.837109', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (153, 1, 81, '2025-01-09 20:10:23.743187', '2025-01-09 20:10:23.743187', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (154, 1, 82, '2025-01-09 20:10:24.961086', '2025-01-09 20:10:24.961086', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (155, 1, 83, '2025-01-09 20:10:27.357399', '2025-01-09 20:10:27.357399', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (156, 10, 54, '2025-01-09 20:44:53.57252', '2025-01-09 20:44:53.57252', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (157, 10, 61, '2025-01-09 20:44:55.245798', '2025-01-09 20:44:55.245798', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (158, 10, 62, '2025-01-09 20:44:57.666511', '2025-01-09 20:44:57.666511', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (159, 10, 63, '2025-01-09 20:44:59.263769', '2025-01-09 20:44:59.263769', NULL, NULL, NULL);
INSERT INTO "public"."group_menu_access" VALUES (160, 10, 55, '2025-01-09 20:46:10.416827', '2025-01-09 20:46:10.416827', NULL, NULL, NULL);

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
INSERT INTO "public"."groups" VALUES (1, 'SA', 'SUPERADMIN', NULL, NULL);
INSERT INTO "public"."groups" VALUES (2, 'B', 'BROKER', NULL, NULL);
INSERT INTO "public"."groups" VALUES (3, 'PO', 'PURCHASING', NULL, NULL);
INSERT INTO "public"."groups" VALUES (4, 'D', 'DRIVER', NULL, NULL);
INSERT INTO "public"."groups" VALUES (5, 'P', 'PRODUKSI', NULL, NULL);
INSERT INTO "public"."groups" VALUES (6, 'QC', 'QC', NULL, NULL);
INSERT INTO "public"."groups" VALUES (8, 'PR', 'PARTING', NULL, NULL);
INSERT INTO "public"."groups" VALUES (9, 'BTC', 'BUTCHEREES', NULL, NULL);
INSERT INTO "public"."groups" VALUES (10, 'K', 'KASIR', NULL, NULL);
INSERT INTO "public"."groups" VALUES (11, 'F', 'FINANCE', NULL, NULL);
INSERT INTO "public"."groups" VALUES (12, 'DP', 'DRIVER & PRODUKSI', NULL, NULL);
INSERT INTO "public"."groups" VALUES (13, 'TL', 'ADMIN ONLINE', NULL, NULL);
INSERT INTO "public"."groups" VALUES (7, 'L', 'KOORDINATOR STORE', NULL, NULL);

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
INSERT INTO "public"."menus" VALUES (55, NULL, 'Transactions', NULL, '-', 2, '2025-01-09 19:48:27.629834', '2025-01-09 19:48:27.629834', 1);
INSERT INTO "public"."menus" VALUES (56, NULL, 'Procurements', NULL, '-', 3, '2025-01-09 19:48:46.74053', '2025-01-09 19:48:46.74053', 1);
INSERT INTO "public"."menus" VALUES (58, NULL, 'Finances', NULL, '-', 5, '2025-01-09 19:50:41.941933', '2025-01-09 19:50:41.941933', 1);
INSERT INTO "public"."menus" VALUES (54, NULL, 'Dashboards', NULL, '-', 1, '2025-01-09 19:48:04.492004', '2025-01-09 19:48:04.492004', 1);
INSERT INTO "public"."menus" VALUES (59, NULL, 'Accounts', NULL, '-', 6, '2025-01-09 19:50:56.424825', '2025-01-09 19:50:56.424825', 1);
INSERT INTO "public"."menus" VALUES (60, NULL, 'Master Data', NULL, '-', 7, '2025-01-09 19:51:11.725244', '2025-01-09 19:51:11.725244', 1);
INSERT INTO "public"."menus" VALUES (57, NULL, 'Inventories', NULL, '-', 4, '2025-01-09 19:50:21.066468', '2025-01-09 19:50:21.066468', 1);
INSERT INTO "public"."menus" VALUES (61, 54, 'Default', 'home', NULL, 1, '2025-01-09 19:53:41.463343', '2025-01-09 19:53:41.463343', 1);
INSERT INTO "public"."menus" VALUES (62, 55, 'Point of Sales', 'transactions', NULL, 1, '2025-01-09 19:54:15.149278', '2025-01-09 19:54:15.149278', 1);
INSERT INTO "public"."menus" VALUES (63, 55, 'Transaction Lists', 'orders', NULL, 2, '2025-01-09 19:54:48.514548', '2025-01-09 19:54:48.514548', 1);
INSERT INTO "public"."menus" VALUES (64, 56, 'Purchase Request', 'procurement/purchase-request', NULL, 1, '2025-01-09 19:56:34.713136', '2025-01-09 19:56:34.713136', 1);
INSERT INTO "public"."menus" VALUES (65, 56, 'Purchase Orders', 'procurement/purchase-order', NULL, 2, '2025-01-09 19:57:06.230733', '2025-01-09 19:57:06.230733', 1);
INSERT INTO "public"."menus" VALUES (66, 56, 'Goods Receive', 'procurement/goods-receive', NULL, 3, '2025-01-09 19:57:29.256272', '2025-01-09 19:57:29.256272', 1);
INSERT INTO "public"."menus" VALUES (67, 57, 'Stock', 'stocks', NULL, 1, '2025-01-09 19:58:02.781344', '2025-01-09 19:58:02.781344', 1);
INSERT INTO "public"."menus" VALUES (69, 58, 'Chart of Accounts', 'finances/chart-of-accounts', NULL, 1, '2025-01-09 19:59:21.522819', '2025-01-09 19:59:21.522819', 1);
INSERT INTO "public"."menus" VALUES (70, 58, 'Journals', 'finances/journals', NULL, 2, '2025-01-09 19:59:41.904092', '2025-01-09 19:59:41.904092', 1);
INSERT INTO "public"."menus" VALUES (71, 58, 'Account Payable (A/P)', 'finances/account-payable', NULL, 3, '2025-01-09 20:00:08.108981', '2025-01-09 20:00:08.108981', 1);
INSERT INTO "public"."menus" VALUES (72, 58, 'Account Receiveables (A/R)', 'finances/account-receivable', NULL, 4, '2025-01-09 20:00:39.204055', '2025-01-09 20:00:39.204055', 1);
INSERT INTO "public"."menus" VALUES (73, 58, 'Expenses', 'finances/expenses', NULL, 5, '2025-01-09 20:01:05.594894', '2025-01-09 20:01:05.594894', 1);
INSERT INTO "public"."menus" VALUES (74, 58, 'Reports', 'finances/reports', NULL, 6, '2025-01-09 20:01:29.92638', '2025-01-09 20:01:29.92638', 1);
INSERT INTO "public"."menus" VALUES (75, 59, 'Users', 'users', NULL, 1, '2025-01-09 20:01:50.38585', '2025-01-09 20:01:50.38585', 1);
INSERT INTO "public"."menus" VALUES (76, 59, 'Groups', 'groups', NULL, 2, '2025-01-09 20:02:12.490479', '2025-01-09 20:02:12.490479', 1);
INSERT INTO "public"."menus" VALUES (77, 59, 'Menus', 'menus', NULL, 3, '2025-01-09 20:02:38.062548', '2025-01-09 20:02:38.062548', 1);
INSERT INTO "public"."menus" VALUES (79, 60, 'Product Categories', 'product-categories', NULL, 2, '2025-01-09 20:03:27.414219', '2025-01-09 20:03:27.414219', 1);
INSERT INTO "public"."menus" VALUES (80, 60, 'Branches (Store)', 'branches', NULL, 3, '2025-01-09 20:03:53.653363', '2025-01-09 20:03:53.653363', 1);
INSERT INTO "public"."menus" VALUES (82, 60, 'Suppliers', 'suppliers', NULL, 5, '2025-01-09 20:04:36.899772', '2025-01-09 20:04:36.899772', 1);
INSERT INTO "public"."menus" VALUES (83, 60, 'Inventory Items', 'suppliers', NULL, 6, '2025-01-09 20:05:06.340814', '2025-01-09 20:05:06.340814', 1);
INSERT INTO "public"."menus" VALUES (81, 60, 'Customers', 'customers', NULL, 4, '2025-01-09 20:04:12.681242', '2025-01-09 20:04:12.681242', 1);
INSERT INTO "public"."menus" VALUES (68, 57, 'Inventory', 'stocks', NULL, 2, '2025-01-09 19:58:43.313989', '2025-01-09 19:58:43.313989', 1);
INSERT INTO "public"."menus" VALUES (78, 60, 'Products', 'products', NULL, 1, '2025-01-09 20:03:03.592832', '2025-01-09 20:03:03.592832', 1);

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
INSERT INTO "public"."product_categories" VALUES (3, 'AYAM HIDUP', 1, '2025-01-09 20:17:21.133019', NULL, '2025-01-09 20:17:21.133019', NULL);
INSERT INTO "public"."product_categories" VALUES (2, 'PARTING', 1, '2025-01-09 20:17:03.935218', NULL, '2025-01-09 20:17:03.935218', NULL);

-- ----------------------------
-- Table structure for product_details
-- ----------------------------
DROP TABLE IF EXISTS "public"."product_details";
CREATE TABLE "public"."product_details" (
  "id" int4 NOT NULL DEFAULT nextval('product_details_id_seq'::regclass),
  "product_id" int4 NOT NULL,
  "price" numeric(10,0) DEFAULT 0,
  "branch_id" int4,
  "discount" numeric(5,0) DEFAULT 0,
  "start_period" date,
  "end_period" date,
  "created_by" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) DEFAULT now(),
  "updated_by" varchar(255) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6) DEFAULT now(),
  "is_active" int2 DEFAULT 0
)
;

-- ----------------------------
-- Records of product_details
-- ----------------------------
INSERT INTO "public"."product_details" VALUES (54, 26, 0, 4, 0, NULL, NULL, NULL, '2025-01-09 20:22:46.344782', NULL, '2025-01-09 20:22:46.344782', 0);
INSERT INTO "public"."product_details" VALUES (55, 26, 0, 5, 0, NULL, NULL, NULL, '2025-01-09 20:22:46.344782', NULL, '2025-01-09 20:22:46.344782', 0);
INSERT INTO "public"."product_details" VALUES (56, 27, 0, 4, 0, NULL, NULL, NULL, '2025-01-09 20:23:15.896815', NULL, '2025-01-09 20:23:15.896815', 0);
INSERT INTO "public"."product_details" VALUES (57, 27, 0, 5, 0, NULL, NULL, NULL, '2025-01-09 20:23:15.896815', NULL, '2025-01-09 20:23:15.896815', 0);
INSERT INTO "public"."product_details" VALUES (67, 32, 29000, 5, 0, NULL, NULL, NULL, '2025-01-09 20:26:20.109212', NULL, '2025-01-09 20:26:20.109212', 1);
INSERT INTO "public"."product_details" VALUES (66, 32, 29000, 4, 0, NULL, NULL, NULL, '2025-01-09 20:26:20.109212', NULL, '2025-01-09 20:26:20.109212', 1);
INSERT INTO "public"."product_details" VALUES (65, 31, 29000, 5, 0, NULL, NULL, NULL, '2025-01-09 20:25:46.584334', NULL, '2025-01-09 20:25:46.584334', 1);
INSERT INTO "public"."product_details" VALUES (64, 31, 29000, 4, 0, NULL, NULL, NULL, '2025-01-09 20:25:46.584334', NULL, '2025-01-09 20:25:46.584334', 1);
INSERT INTO "public"."product_details" VALUES (63, 30, 29000, 5, 0, NULL, NULL, NULL, '2025-01-09 20:25:27.506208', NULL, '2025-01-09 20:25:27.506208', 1);
INSERT INTO "public"."product_details" VALUES (62, 30, 29000, 4, 0, NULL, NULL, NULL, '2025-01-09 20:25:27.506208', NULL, '2025-01-09 20:25:27.506208', 1);
INSERT INTO "public"."product_details" VALUES (61, 29, 29000, 5, 0, NULL, NULL, NULL, '2025-01-09 20:24:58.049735', NULL, '2025-01-09 20:24:58.049735', 1);
INSERT INTO "public"."product_details" VALUES (60, 29, 29000, 4, 0, NULL, NULL, NULL, '2025-01-09 20:24:58.049735', NULL, '2025-01-09 20:24:58.049735', 1);
INSERT INTO "public"."product_details" VALUES (59, 28, 29000, 5, 0, NULL, NULL, NULL, '2025-01-09 20:23:45.539466', NULL, '2025-01-09 20:23:45.539466', 1);
INSERT INTO "public"."product_details" VALUES (58, 28, 29000, 4, 0, NULL, NULL, NULL, '2025-01-09 20:23:45.539466', NULL, '2025-01-09 20:23:45.539466', 1);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS "public"."products";
CREATE TABLE "public"."products" (
  "id" int4 NOT NULL DEFAULT nextval('products_id_seq'::regclass),
  "code" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
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
INSERT INTO "public"."products" VALUES (26, 'AH', 'AYAM HIDUP', 1, '2025-01-09 20:22:46.344782', NULL, '2025-01-09 20:22:46.344782', NULL, NULL, 3);
INSERT INTO "public"."products" VALUES (27, 'AR', 'AYAM RANCUNG', 1, '2025-01-09 20:23:15.896815', NULL, '2025-01-09 20:23:15.896815', NULL, NULL, 2);
INSERT INTO "public"."products" VALUES (28, 'KKS', 'KARKAS', 1, '2025-01-09 20:23:45.539466', NULL, '2025-01-09 20:23:45.539466', NULL, NULL, 2);
INSERT INTO "public"."products" VALUES (29, 'DD', 'DADA', 1, '2025-01-09 20:24:58.049735', NULL, '2025-01-09 20:24:58.049735', NULL, NULL, 2);
INSERT INTO "public"."products" VALUES (30, 'PH', 'PAHA', 1, '2025-01-09 20:25:27.506208', NULL, '2025-01-09 20:25:27.506208', NULL, NULL, 2);
INSERT INTO "public"."products" VALUES (31, 'PHA', 'PAHA ATAS', 1, '2025-01-09 20:25:46.584334', NULL, '2025-01-09 20:25:46.584334', NULL, NULL, 2);
INSERT INTO "public"."products" VALUES (32, 'PHP', 'PAHA PENTUL', 1, '2025-01-09 20:26:20.109212', NULL, '2025-01-09 20:26:20.109212', NULL, NULL, 2);

-- ----------------------------
-- Table structure for purchase_order_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_order_items";
CREATE TABLE "public"."purchase_order_items" (
  "id" int4 NOT NULL DEFAULT nextval('purchase_order_items_id_seq'::regclass),
  "purchase_order_id" int4 NOT NULL,
  "purchase_request_item_id" int4 NOT NULL,
  "item_id" int4 NOT NULL,
  "quantity" numeric(10,2) NOT NULL,
  "price" numeric(10,0) NOT NULL,
  "received_quantity" numeric(10,2),
  "received_price" numeric(10,0),
  "remarks" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of purchase_order_items
-- ----------------------------

-- ----------------------------
-- Table structure for purchase_orders
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_orders";
CREATE TABLE "public"."purchase_orders" (
  "id" int4 NOT NULL DEFAULT nextval('purchase_orders_id_seq'::regclass),
  "purchase_order_number" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "supplier_id" int4 NOT NULL,
  "status" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "order_date" date,
  "category" varchar(50) COLLATE "pg_catalog"."default",
  "total_amount" numeric(10,0),
  "final_total_amount" numeric(10,0),
  "received_date" date,
  "received_by" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of purchase_orders
-- ----------------------------

-- ----------------------------
-- Table structure for purchase_request_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_request_items";
CREATE TABLE "public"."purchase_request_items" (
  "id" int4 NOT NULL DEFAULT nextval('purchase_request_items_id_seq'::regclass),
  "purchase_request_id" int4 NOT NULL,
  "item_id" int4 NOT NULL,
  "category" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "quantity" numeric(10,0) NOT NULL,
  "price" numeric(10,0) NOT NULL,
  "approval_status" int2 DEFAULT 0,
  "realisation" int2 DEFAULT 0
)
;

-- ----------------------------
-- Records of purchase_request_items
-- ----------------------------

-- ----------------------------
-- Table structure for purchase_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_requests";
CREATE TABLE "public"."purchase_requests" (
  "id" int4 NOT NULL DEFAULT nextval('purchase_requests_id_seq'::regclass),
  "request_number" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "alocation" int4 NOT NULL,
  "request_date" date NOT NULL,
  "pic" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "category" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6),
  "has_proccessed" int2 DEFAULT 0,
  "approval_date" timestamp(6),
  "remarks" text COLLATE "pg_catalog"."default",
  "nominal_application" numeric(10,0),
  "nominal_realization" numeric(10,0),
  "approved_by" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of purchase_requests
-- ----------------------------

-- ----------------------------
-- Table structure for stock_logs
-- ----------------------------
DROP TABLE IF EXISTS "public"."stock_logs";
CREATE TABLE "public"."stock_logs" (
  "id" int4 NOT NULL DEFAULT nextval('stock_logs_id_seq'::regclass),
  "stock_id" int4 NOT NULL,
  "in_quantity" int4 DEFAULT 0,
  "out_quantity" int4 DEFAULT 0,
  "date" timestamp(6) DEFAULT now(),
  "reference" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of stock_logs
-- ----------------------------

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS "public"."stocks";
CREATE TABLE "public"."stocks" (
  "id" int4 NOT NULL DEFAULT nextval('stocks_id_seq'::regclass),
  "product_id" int4 NOT NULL,
  "quantity" int4 NOT NULL,
  "branch_id" int4
)
;

-- ----------------------------
-- Records of stocks
-- ----------------------------

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS "public"."suppliers";
CREATE TABLE "public"."suppliers" (
  "id" int4 NOT NULL DEFAULT nextval('suppliers_id_seq'::regclass),
  "name" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "phone_number" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "address" text COLLATE "pg_catalog"."default" NOT NULL,
  "is_active" int4 NOT NULL,
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_by" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO "public"."suppliers" VALUES (1, 'ASTOT 1', '082627228', 'Cidarengdeng Sukaresmi Garut', 1, '2025-01-01 22:12:47.555966', '1');

-- ----------------------------
-- Table structure for transaction_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."transaction_items";
CREATE TABLE "public"."transaction_items" (
  "id" int4 NOT NULL DEFAULT nextval('transaction_items_id_seq'::regclass),
  "transaction_id" int4,
  "product_id" int4,
  "quantity" numeric(10,2),
  "unit_price" numeric(10,0),
  "base_price" numeric(10,0),
  "discount" numeric(10,0) DEFAULT 0
)
;

-- ----------------------------
-- Records of transaction_items
-- ----------------------------

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
  "discount" numeric(10,0) DEFAULT 0,
  "shipping_cost" numeric(10,0) DEFAULT 0,
  "branch_id" int4,
  "butcher_name" varchar(50) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of transactions
-- ----------------------------

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
INSERT INTO "public"."users" VALUES (1, 'admin', 'admin@gmail.com', NULL, '$2y$10$5IFbNv.tVM0j66nhHQsaz.PbMYBYZcnKWeYUT022WJSkCuvT0M0TK', NULL, 1, '2024-11-23 04:36:01', '2024-11-27 10:17:36', 1, 1);
INSERT INTO "public"."users" VALUES (1109, 'user1', 'user1@gmail.com', NULL, '$2y$10$njOftKSt5nBOkPKIcLjOvu0AuSi7TFD/IjW1.hEiCOfpzrdQ7sRem', NULL, 10, '2025-01-09 01:36:59', NULL, 1, 4);
INSERT INTO "public"."users" VALUES (1110, 'user2', 'user2@gmail.com', NULL, '$2y$10$QGKvfR1HKvlPpeo31T8sd.NpMSFM9HU1vH9FjW7wQlk5AeXzpelKu', NULL, 10, '2025-01-09 01:38:05', NULL, 1, 5);

-- ----------------------------
-- Function structure for generate_purchase_order_number
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."generate_purchase_order_number"();
CREATE OR REPLACE FUNCTION "public"."generate_purchase_order_number"()
  RETURNS "pg_catalog"."text" AS $BODY$
DECLARE
  seq_num TEXT;
  year_month TEXT;
BEGIN
  -- Get the current year and month in YYYYMM format
  year_month := TO_CHAR(CURRENT_DATE, 'YYYYMM');
  
  -- Get the next sequence value, padded to 5 digits
  seq_num := LPAD(NEXTVAL('purchase_order_sequence')::TEXT, 5, '0');
  
  -- Combine the fixed part, year_month, and sequence number
  RETURN 'PO' || year_month || seq_num;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for generate_purchase_request_number
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."generate_purchase_request_number"();
CREATE OR REPLACE FUNCTION "public"."generate_purchase_request_number"()
  RETURNS "pg_catalog"."text" AS $BODY$
DECLARE
  seq_num TEXT;
  year_month TEXT;
BEGIN
  -- Get the current year and month in YYYYMM format
  year_month := TO_CHAR(CURRENT_DATE, 'YYYYMM');
  
  -- Get the next sequence value, padded to 5 digits
  seq_num := LPAD(NEXTVAL('purchase_request_sequence')::TEXT, 5, '0');
  
  -- Combine the fixed part, year_month, and sequence number
  RETURN 'PR' || year_month || seq_num;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for generate_transaction_code
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."generate_transaction_code"("params" varchar);
CREATE OR REPLACE FUNCTION "public"."generate_transaction_code"("params" varchar)
  RETURNS "pg_catalog"."varchar" AS $BODY$
DECLARE
    current_year VARCHAR;
    current_month VARCHAR;
    new_sequence INTEGER;
    padded_sequence VARCHAR;
BEGIN
    -- Validate params
    IF params IS NULL OR params = '' THEN
        RAISE EXCEPTION 'Branch code cannot be null or empty';
    END IF;

    -- Get the current year and month
    current_year := TO_CHAR(NOW(), 'YYYY');  -- Current year (YYYY)
    current_month := TO_CHAR(NOW(), 'MM');   -- Current month (MM)

    -- Ensure the branch sequence exists or initialize it
    PERFORM 1 FROM branch_sequences WHERE branch_code = params;
    IF NOT FOUND THEN
        INSERT INTO branch_sequences (branch_code, current_sequence)
        VALUES (params, 0);
    END IF;

    -- Increment and fetch the new sequence value
    UPDATE branch_sequences
    SET current_sequence = current_sequence + 1, updated_at = NOW()
    WHERE branch_code = params
    RETURNING current_sequence INTO new_sequence;

    -- Format the sequence number as a 5-digit string (pad with leading zeros)
    padded_sequence := LPAD(new_sequence::TEXT, 5, '0');

    -- Generate the final transaction code
    RETURN params || current_year || current_month || padded_sequence;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."branch_sequences_id_seq"
OWNED BY "public"."branch_sequences"."id";
SELECT setval('"public"."branch_sequences_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."branches_id_seq"
OWNED BY "public"."branches"."id";
SELECT setval('"public"."branches_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."chart_of_accounts_id_seq"
OWNED BY "public"."chart_of_accounts"."id";
SELECT setval('"public"."chart_of_accounts_id_seq"', 16, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."customers_id_seq"', 7, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."failed_jobs_id_seq"
OWNED BY "public"."failed_jobs"."id";
SELECT setval('"public"."failed_jobs_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."goods_received_id_seq"
OWNED BY "public"."goods_received"."id";
SELECT setval('"public"."goods_received_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."goods_received_items_id_seq"
OWNED BY "public"."goods_received_items"."id";
SELECT setval('"public"."goods_received_items_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."menus_id_seq"
OWNED BY "public"."menus"."id";
SELECT setval('"public"."menus_id_seq"', 83, true);

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
SELECT setval('"public"."product_categories_id_seq1"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."product_details_id_seq"
OWNED BY "public"."product_details"."id";
SELECT setval('"public"."product_details_id_seq"', 67, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."products_id_seq"
OWNED BY "public"."products"."id";
SELECT setval('"public"."products_id_seq"', 32, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_order_items_id_seq"
OWNED BY "public"."purchase_order_items"."id";
SELECT setval('"public"."purchase_order_items_id_seq"', 21, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."purchase_order_sequence"', 18, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_orders_id_seq"
OWNED BY "public"."purchase_orders"."id";
SELECT setval('"public"."purchase_orders_id_seq"', 11, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_request_items_id_seq"
OWNED BY "public"."purchase_request_items"."id";
SELECT setval('"public"."purchase_request_items_id_seq"', 15, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."purchase_request_sequence"', 13, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_requests_id_seq"
OWNED BY "public"."purchase_requests"."id";
SELECT setval('"public"."purchase_requests_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."role_menu_access_id_seq"
OWNED BY "public"."group_menu_access"."id";
SELECT setval('"public"."role_menu_access_id_seq"', 160, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."stock_logs_id_seq"
OWNED BY "public"."stock_logs"."id";
SELECT setval('"public"."stock_logs_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."stocks_id_seq"
OWNED BY "public"."stocks"."id";
SELECT setval('"public"."stocks_id_seq"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."suppliers_id_seq"
OWNED BY "public"."suppliers"."id";
SELECT setval('"public"."suppliers_id_seq"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."transaction_code_sequence"', 29, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."transaction_items_id_seq"
OWNED BY "public"."transaction_items"."id";
SELECT setval('"public"."transaction_items_id_seq"', 131, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."transactions_id_seq"
OWNED BY "public"."transactions"."id";
SELECT setval('"public"."transactions_id_seq"', 49, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_groups_id_seq"
OWNED BY "public"."groups"."id";
SELECT setval('"public"."user_groups_id_seq"', 13, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_id_seq"
OWNED BY "public"."users"."id";
SELECT setval('"public"."users_id_seq"', 1110, true);

-- ----------------------------
-- Uniques structure for table branch_sequences
-- ----------------------------
ALTER TABLE "public"."branch_sequences" ADD CONSTRAINT "branch_sequences_branch_code_key" UNIQUE ("branch_code");

-- ----------------------------
-- Primary Key structure for table branch_sequences
-- ----------------------------
ALTER TABLE "public"."branch_sequences" ADD CONSTRAINT "branch_sequences_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table branches
-- ----------------------------
ALTER TABLE "public"."branches" ADD CONSTRAINT "branches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table chart_of_accounts
-- ----------------------------
ALTER TABLE "public"."chart_of_accounts" ADD CONSTRAINT "chart_of_accounts_code_key" UNIQUE ("code");

-- ----------------------------
-- Primary Key structure for table chart_of_accounts
-- ----------------------------
ALTER TABLE "public"."chart_of_accounts" ADD CONSTRAINT "chart_of_accounts_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid");

-- ----------------------------
-- Primary Key structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table goods_received
-- ----------------------------
ALTER TABLE "public"."goods_received" ADD CONSTRAINT "goods_received_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table goods_received_items
-- ----------------------------
ALTER TABLE "public"."goods_received_items" ADD CONSTRAINT "goods_received_items_pkey" PRIMARY KEY ("id");

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
SELECT setval('"public"."product_categories_id_seq1"', 3, true);

-- ----------------------------
-- Primary Key structure for table product_categories
-- ----------------------------
ALTER TABLE "public"."product_categories" ADD CONSTRAINT "product_categories_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table product_details
-- ----------------------------
ALTER TABLE "public"."product_details" ADD CONSTRAINT "product_details_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CONSTRAINT "products_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table purchase_order_items
-- ----------------------------
ALTER TABLE "public"."purchase_order_items" ADD CONSTRAINT "purchase_order_items_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table purchase_orders
-- ----------------------------
ALTER TABLE "public"."purchase_orders" ADD CONSTRAINT "purchase_orders_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table purchase_request_items
-- ----------------------------
ALTER TABLE "public"."purchase_request_items" ADD CONSTRAINT "purchase_request_items_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table purchase_requests
-- ----------------------------
ALTER TABLE "public"."purchase_requests" ADD CONSTRAINT "purchase_requests_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table stock_logs
-- ----------------------------
ALTER TABLE "public"."stock_logs" ADD CONSTRAINT "stock_logs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table stocks
-- ----------------------------
ALTER TABLE "public"."stocks" ADD CONSTRAINT "stocks_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table suppliers
-- ----------------------------
ALTER TABLE "public"."suppliers" ADD CONSTRAINT "suppliers_pkey" PRIMARY KEY ("id");

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
-- Foreign Keys structure for table product_details
-- ----------------------------
ALTER TABLE "public"."product_details" ADD CONSTRAINT "fk_branch_id" FOREIGN KEY ("branch_id") REFERENCES "public"."branches" ("id") ON DELETE SET NULL ON UPDATE NO ACTION;
ALTER TABLE "public"."product_details" ADD CONSTRAINT "fk_product_id" FOREIGN KEY ("product_id") REFERENCES "public"."products" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CONSTRAINT "fk_category" FOREIGN KEY ("category_id") REFERENCES "public"."product_categories" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table stock_logs
-- ----------------------------
ALTER TABLE "public"."stock_logs" ADD CONSTRAINT "fk_stock_id" FOREIGN KEY ("stock_id") REFERENCES "public"."stocks" ("id") ON DELETE RESTRICT ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table stocks
-- ----------------------------
ALTER TABLE "public"."stocks" ADD CONSTRAINT "fk_branch_id" FOREIGN KEY ("branch_id") REFERENCES "public"."branches" ("id") ON DELETE SET NULL ON UPDATE NO ACTION;
ALTER TABLE "public"."stocks" ADD CONSTRAINT "fk_product_id" FOREIGN KEY ("product_id") REFERENCES "public"."products" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table transaction_items
-- ----------------------------
ALTER TABLE "public"."transaction_items" ADD CONSTRAINT "transaction_items_product_id_fkey" FOREIGN KEY ("product_id") REFERENCES "public"."products" ("id") ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE "public"."transaction_items" ADD CONSTRAINT "transaction_items_transaction_id_fkey" FOREIGN KEY ("transaction_id") REFERENCES "public"."transactions" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
