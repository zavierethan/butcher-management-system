/*
 Navicat Premium Data Transfer

 Source Server         : bimeta
 Source Server Type    : PostgreSQL
 Source Server Version : 160001 (160001)
 Source Host           : localhost:5432
 Source Catalog        : bimeta_2
 Source Schema         : transaction

 Target Server Type    : PostgreSQL
 Target Server Version : 160001 (160001)
 File Encoding         : 65001

 Date: 13/01/2025 04:01:33
*/


-- ----------------------------
-- Table structure for t_spk
-- ----------------------------
DROP TABLE IF EXISTS "transaction"."t_spk";
CREATE TABLE "transaction"."t_spk" (
  "id" int4 NOT NULL DEFAULT nextval('"transaction".t_spk_seq'::regclass),
  "detail_sales_order_id" int4,
  "spk_no" varchar(50) COLLATE "pg_catalog"."default",
  "start_date" date,
  "finish_date" date,
  "quantity" int4,
  "length" numeric(10,0),
  "width" numeric(10,0),
  "height" numeric(10,0),
  "l2" numeric(10,0),
  "p1" numeric(10,0),
  "l1" numeric(10,0),
  "p2" numeric(10,0),
  "t" numeric(10,0),
  "plape" numeric(10,0),
  "k" numeric(10,0),
  "netto_width" numeric(10,0),
  "netto_length" numeric(10,0),
  "bruto_width" numeric(10,0),
  "bruto_length" numeric(10,0),
  "sheet_quantity" int4,
  "flag_stitching" int2,
  "flag_glue" int2,
  "flag_pounch" int2,
  "status" int4,
  "current_process" varchar(50) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "created_by" varchar(50) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6),
  "updated_by" varchar(50) COLLATE "pg_catalog"."default",
  "persentage" numeric(10,0) DEFAULT 0,
  "specification" varchar(50) COLLATE "pg_catalog"."default",
  "spk_type" varchar(50) COLLATE "pg_catalog"."default",
  "flute_type" varchar(50) COLLATE "pg_catalog"."default",
  "show_layout" int2,
  "layout_type" varchar(50) COLLATE "pg_catalog"."default",
  "plape_1" numeric(10,0),
  "plape_2" numeric(10,0),
  "sup_bruto_width" numeric(10,0),
  "sup_bruto_length" numeric(10,0),
  "jp" numeric(10,0),
  "jl" numeric(10,0)
)
;

-- ----------------------------
-- Primary Key structure for table t_spk
-- ----------------------------
ALTER TABLE "transaction"."t_spk" ADD CONSTRAINT "t_spk_pkey" PRIMARY KEY ("id");
