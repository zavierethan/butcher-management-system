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

 Date: 10/12/2024 19:31:57
*/


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
INSERT INTO "public"."menus" VALUES (28, 27, 'Default', 'http://localhost:8000/home', NULL, 1, '2024-12-10 19:21:34.99048', '2024-12-10 19:21:34.99048', 1);
INSERT INTO "public"."menus" VALUES (30, 29, 'Point of Sales', 'http://localhost:8000/transactions', '-', 1, '2024-12-10 19:22:40.225983', '2024-12-10 19:22:40.225983', 1);
INSERT INTO "public"."menus" VALUES (32, 31, 'Users', 'http://localhost:8000/users', '-', 1, '2024-12-10 19:23:23.245531', '2024-12-10 19:23:23.245531', 1);
INSERT INTO "public"."menus" VALUES (33, 31, 'Groups', 'http://localhost:8000/groups', '-', 2, '2024-12-10 19:23:43.072009', '2024-12-10 19:23:43.072009', 1);
INSERT INTO "public"."menus" VALUES (34, 31, 'Menus', 'http://localhost:8000/menus', '-', 3, '2024-12-10 19:24:06.927427', '2024-12-10 19:24:06.927427', 1);
INSERT INTO "public"."menus" VALUES (36, 35, 'Products', 'http://localhost:8000/products', '-', 1, '2024-12-10 19:25:19.137683', '2024-12-10 19:25:19.137683', 1);
INSERT INTO "public"."menus" VALUES (37, 35, 'Branches (Outlets)', 'http://localhost:8000/branches', '-', 2, '2024-12-10 19:25:57.012285', '2024-12-10 19:25:57.012285', 1);
INSERT INTO "public"."menus" VALUES (31, NULL, 'Account Settings', NULL, '<i class="fa-solid fa-user-gear"></i>', 3, '2024-12-10 19:23:04.127476', '2024-12-10 19:23:04.127476', 1);
INSERT INTO "public"."menus" VALUES (35, NULL, 'Master Data', NULL, '<i class="fa-solid fa-database"></i>', 4, '2024-12-10 19:24:52.034887', '2024-12-10 19:24:52.034887', 1);
INSERT INTO "public"."menus" VALUES (27, NULL, 'Dashboard', NULL, '<i class="fa-solid fa-chart-line"></i>', 1, '2024-12-10 19:20:41.346046', '2024-12-10 19:20:41.346046', 1);
INSERT INTO "public"."menus" VALUES (29, NULL, 'Transactions', NULL, '<i class="fa-solid fa-shop"></i>', 2, '2024-12-10 19:22:09.107133', '2024-12-10 19:22:09.107133', 1);

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
  "is_active" int2
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES (2, 'admin', 'admin@gmail.com', NULL, '$2y$10$5IFbNv.tVM0j66nhHQsaz.PbMYBYZcnKWeYUT022WJSkCuvT0M0TK', NULL, 1, '2024-11-23 04:36:01', '2024-11-27 10:17:36', 1);

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
SELECT setval('"public"."menus_id_seq"', 37, true);

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
ALTER SEQUENCE "public"."role_menu_access_id_seq"
OWNED BY "public"."group_menu_access"."id";
SELECT setval('"public"."role_menu_access_id_seq"', 93, true);

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
