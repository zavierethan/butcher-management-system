--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2024-12-15 20:31:56 WIB

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3598 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 236 (class 1259 OID 16648)
-- Name: branches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.branches (
    id integer NOT NULL,
    code character varying(50) NOT NULL,
    name character varying(100) NOT NULL,
    address text NOT NULL,
    is_active smallint,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    created_by character varying(50),
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_by character varying(50)
);


ALTER TABLE public.branches OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 16647)
-- Name: branches_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.branches_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.branches_id_seq OWNER TO postgres;

--
-- TOC entry 3599 (class 0 OID 0)
-- Dependencies: 235
-- Name: branches_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.branches_id_seq OWNED BY public.branches.id;


--
-- TOC entry 238 (class 1259 OID 16659)
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.customers (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    ktp_number character varying(50),
    phone_number character varying(20),
    type character varying(50) NOT NULL,
    is_active smallint,
    created_by character varying(50),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_by character varying(50),
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.customers OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 16658)
-- Name: customers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.customers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.customers_id_seq OWNER TO postgres;

--
-- TOC entry 3600 (class 0 OID 0)
-- Dependencies: 237
-- Name: customers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.customers_id_seq OWNED BY public.customers.id;


--
-- TOC entry 223 (class 1259 OID 16549)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16541)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 3601 (class 0 OID 0)
-- Dependencies: 215
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 224 (class 1259 OID 16556)
-- Name: group_menu_access; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.group_menu_access (
    id integer NOT NULL,
    group_id integer,
    menu_id integer,
    created_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    can_view integer,
    can_edit integer,
    can_delete integer
);


ALTER TABLE public.group_menu_access OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16562)
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groups (
    id bigint NOT NULL,
    code character varying(50) NOT NULL,
    name character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16566)
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id integer NOT NULL,
    parent_id integer,
    name character varying(255) NOT NULL,
    url character varying(255),
    icon character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    is_active smallint
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16542)
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- TOC entry 3602 (class 0 OID 0)
-- Dependencies: 216
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- TOC entry 227 (class 1259 OID 16575)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16543)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 3603 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 228 (class 1259 OID 16579)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 16584)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16589)
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    "desc" character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16544)
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- TOC entry 3604 (class 0 OID 0)
-- Dependencies: 218
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- TOC entry 231 (class 1259 OID 16593)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16545)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 3605 (class 0 OID 0)
-- Dependencies: 219
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 240 (class 1259 OID 16668)
-- Name: product_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_categories (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    is_active smallint,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    created_by character varying(50),
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_by character varying(50)
);


ALTER TABLE public.product_categories OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 16667)
-- Name: product_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_categories_id_seq OWNER TO postgres;

--
-- TOC entry 3606 (class 0 OID 0)
-- Dependencies: 239
-- Name: product_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_categories_id_seq OWNED BY public.product_categories.id;


--
-- TOC entry 234 (class 1259 OID 16638)
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id integer NOT NULL,
    code character varying(50) NOT NULL,
    name character varying(100) NOT NULL,
    price numeric(10,2) NOT NULL,
    is_active smallint,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    created_by character varying(50),
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_by character varying(50),
    category_id integer NOT NULL,
    url_path character varying(255),
    CONSTRAINT products_price_check CHECK ((price >= (0)::numeric))
);


ALTER TABLE public.products OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 16637)
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- TOC entry 3607 (class 0 OID 0)
-- Dependencies: 233
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- TOC entry 220 (class 1259 OID 16546)
-- Name: role_menu_access_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.role_menu_access_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER SEQUENCE public.role_menu_access_id_seq OWNER TO postgres;

--
-- TOC entry 3608 (class 0 OID 0)
-- Dependencies: 220
-- Name: role_menu_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.role_menu_access_id_seq OWNED BY public.group_menu_access.id;


--
-- TOC entry 221 (class 1259 OID 16547)
-- Name: user_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_groups_id_seq OWNER TO postgres;

--
-- TOC entry 3609 (class 0 OID 0)
-- Dependencies: 221
-- Name: user_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_groups_id_seq OWNED BY public.groups.id;


--
-- TOC entry 232 (class 1259 OID 16599)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    group_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    is_active smallint
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16548)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 3610 (class 0 OID 0)
-- Dependencies: 222
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3378 (class 2604 OID 16651)
-- Name: branches id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.branches ALTER COLUMN id SET DEFAULT nextval('public.branches_id_seq'::regclass);


--
-- TOC entry 3381 (class 2604 OID 16662)
-- Name: customers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.customers_id_seq'::regclass);


--
-- TOC entry 3361 (class 2604 OID 16552)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 3363 (class 2604 OID 16559)
-- Name: group_menu_access id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_menu_access ALTER COLUMN id SET DEFAULT nextval('public.role_menu_access_id_seq'::regclass);


--
-- TOC entry 3366 (class 2604 OID 16565)
-- Name: groups id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.user_groups_id_seq'::regclass);


--
-- TOC entry 3367 (class 2604 OID 16569)
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- TOC entry 3371 (class 2604 OID 16578)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 3372 (class 2604 OID 16592)
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- TOC entry 3373 (class 2604 OID 16596)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 3384 (class 2604 OID 16671)
-- Name: product_categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_categories ALTER COLUMN id SET DEFAULT nextval('public.product_categories_id_seq'::regclass);


--
-- TOC entry 3375 (class 2604 OID 16641)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- TOC entry 3374 (class 2604 OID 16602)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3588 (class 0 OID 16648)
-- Dependencies: 236
-- Data for Name: branches; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.branches VALUES (2, 'Y002', 'Cabang B', 'Jl. fghi', 1, '2024-12-14 10:53:36.500483', NULL, '2024-12-14 10:53:36.500483', NULL);
INSERT INTO public.branches VALUES (1, 'Y001x', 'Cabang Ax', 'Jl. abcdex', 1, '2024-12-14 10:53:15.898004', NULL, '2024-12-14 10:53:15.898004', NULL);


--
-- TOC entry 3590 (class 0 OID 16659)
-- Dependencies: 238
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.customers VALUES (1, 'Hendri', '0123456789', '0821333888777', 'Perorangan', 1, NULL, '2024-12-14 11:33:43.711089', NULL, '2024-12-14 11:33:43.711089');
INSERT INTO public.customers VALUES (2, 'Satyaa', '099922278884328', '08215556667778', 'Perusahaan/Kolektif', 1, NULL, '2024-12-14 11:34:05.185507', NULL, '2024-12-14 11:34:05.185507');


--
-- TOC entry 3575 (class 0 OID 16549)
-- Dependencies: 223
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3576 (class 0 OID 16556)
-- Dependencies: 224
-- Data for Name: group_menu_access; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.group_menu_access VALUES (82, 2, 26, '2024-12-10 14:42:46.230803', '2024-12-10 14:42:46.230803', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (83, 1, 27, '2024-12-10 19:26:16.391966', '2024-12-10 19:26:16.391966', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (84, 1, 28, '2024-12-10 19:26:19.080464', '2024-12-10 19:26:19.080464', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (85, 1, 29, '2024-12-10 19:26:22.718246', '2024-12-10 19:26:22.718246', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (86, 1, 30, '2024-12-10 19:26:25.426336', '2024-12-10 19:26:25.426336', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (87, 1, 31, '2024-12-10 19:26:27.486779', '2024-12-10 19:26:27.486779', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (88, 1, 32, '2024-12-10 19:26:29.333733', '2024-12-10 19:26:29.333733', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (89, 1, 33, '2024-12-10 19:26:31.248525', '2024-12-10 19:26:31.248525', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (90, 1, 34, '2024-12-10 19:26:33.28795', '2024-12-10 19:26:33.28795', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (91, 1, 35, '2024-12-10 19:26:35.207362', '2024-12-10 19:26:35.207362', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (92, 1, 36, '2024-12-10 19:26:38.047798', '2024-12-10 19:26:38.047798', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (93, 1, 37, '2024-12-10 19:26:40.383702', '2024-12-10 19:26:40.383702', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (94, 1, 39, '2024-12-10 20:56:32.312186', '2024-12-10 20:56:32.312186', NULL, NULL, NULL);
INSERT INTO public.group_menu_access VALUES (95, 1, 40, '2024-12-14 11:55:13.818615', '2024-12-14 11:55:13.818615', NULL, NULL, NULL);


--
-- TOC entry 3577 (class 0 OID 16562)
-- Dependencies: 225
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groups VALUES (4, 'G00001', 'SUPARADMIN', NULL, NULL);
INSERT INTO public.groups VALUES (1, 'G00001', 'SUPARADMIN', '2024-11-25 22:54:07', NULL);


--
-- TOC entry 3578 (class 0 OID 16566)
-- Dependencies: 226
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.menus VALUES (28, 27, 'Default', 'http://localhost:8000/home', NULL, 1, '2024-12-10 19:21:34.99048', '2024-12-10 19:21:34.99048', 1);
INSERT INTO public.menus VALUES (30, 29, 'Point of Sales', 'http://localhost:8000/transactions', '-', 1, '2024-12-10 19:22:40.225983', '2024-12-10 19:22:40.225983', 1);
INSERT INTO public.menus VALUES (32, 31, 'Users', 'http://localhost:8000/users', '-', 1, '2024-12-10 19:23:23.245531', '2024-12-10 19:23:23.245531', 1);
INSERT INTO public.menus VALUES (34, 31, 'Menus', 'http://localhost:8000/menus', '-', 3, '2024-12-10 19:24:06.927427', '2024-12-10 19:24:06.927427', 1);
INSERT INTO public.menus VALUES (37, 35, 'Branches (Outlets)', 'http://localhost:8000/branches', '-', 2, '2024-12-10 19:25:57.012285', '2024-12-10 19:25:57.012285', 1);
INSERT INTO public.menus VALUES (31, NULL, 'Account Settings', NULL, '<i class="fa-solid fa-user-gear"></i>', 3, '2024-12-10 19:23:04.127476', '2024-12-10 19:23:04.127476', 1);
INSERT INTO public.menus VALUES (35, NULL, 'Master Data', NULL, '<i class="fa-solid fa-database"></i>', 4, '2024-12-10 19:24:52.034887', '2024-12-10 19:24:52.034887', 1);
INSERT INTO public.menus VALUES (27, NULL, 'Dashboard', NULL, '<i class="fa-solid fa-chart-line"></i>', 1, '2024-12-10 19:20:41.346046', '2024-12-10 19:20:41.346046', 1);
INSERT INTO public.menus VALUES (29, NULL, 'Transactions', NULL, '<i class="fa-solid fa-shop"></i>', 2, '2024-12-10 19:22:09.107133', '2024-12-10 19:22:09.107133', 1);
INSERT INTO public.menus VALUES (33, 31, 'Groups', 'http://localhost:8000/groups', '-', 2, '2024-12-10 19:23:43.072009', '2024-12-10 19:23:43.072009', 1);
INSERT INTO public.menus VALUES (36, 35, 'Products', 'http://localhost:8000/products', '-', 1, '2024-12-10 19:25:19.137683', '2024-12-10 19:25:19.137683', 1);
INSERT INTO public.menus VALUES (39, 35, 'Customer', 'customers', '-', 3, '2024-12-10 20:34:05.516644', '2024-12-10 20:34:05.516644', 1);
INSERT INTO public.menus VALUES (40, 35, 'Product Category', 'product-categories', '-', 4, '2024-12-14 11:55:03.353119', '2024-12-14 11:55:03.353119', 1);


--
-- TOC entry 3579 (class 0 OID 16575)
-- Dependencies: 227
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.migrations VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO public.migrations VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO public.migrations VALUES (3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO public.migrations VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO public.migrations VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO public.migrations VALUES (6, '2024_09_29_112508_create_user_groups_table', 1);
INSERT INTO public.migrations VALUES (7, '2024_09_29_113257_create_permissions_table', 2);


--
-- TOC entry 3580 (class 0 OID 16579)
-- Dependencies: 228
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3581 (class 0 OID 16584)
-- Dependencies: 229
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3582 (class 0 OID 16589)
-- Dependencies: 230
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3583 (class 0 OID 16593)
-- Dependencies: 231
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3592 (class 0 OID 16668)
-- Dependencies: 240
-- Data for Name: product_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.product_categories VALUES (1, 'Fillet', 1, '2024-12-14 11:58:48.488357', NULL, '2024-12-14 11:58:48.488357', NULL);
INSERT INTO public.product_categories VALUES (2, 'Jeroan', 1, '2024-12-14 12:05:24.025883', NULL, '2024-12-14 12:05:24.025883', NULL);


--
-- TOC entry 3586 (class 0 OID 16638)
-- Dependencies: 234
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.products VALUES (15, 'P001', 'Dada', 25.00, 1, '2024-12-14 12:16:02.996131', NULL, '2024-12-14 12:16:02.996131', NULL, 1, NULL);
INSERT INTO public.products VALUES (17, 'P002', 'Usus', 12.00, 1, '2024-12-14 12:34:26.277742', NULL, '2024-12-14 12:34:26.277742', NULL, 2, NULL);


--
-- TOC entry 3584 (class 0 OID 16599)
-- Dependencies: 232
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (2, 'admin', 'admin@gmail.com', NULL, '$2y$10$5IFbNv.tVM0j66nhHQsaz.PbMYBYZcnKWeYUT022WJSkCuvT0M0TK', NULL, 1, '2024-11-23 04:36:01', '2024-11-27 10:17:36', 1);
INSERT INTO public.users VALUES (1106, 'john', 'johndoe@gmail.com', NULL, '$2y$10$yrjSwjawhLZ1rSweqZLOJ.2pxf9DzicmkPqfN.RRMKffdY1QXxNDW', NULL, 1, '2024-12-10 01:19:01', NULL, 1);


--
-- TOC entry 3611 (class 0 OID 0)
-- Dependencies: 235
-- Name: branches_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.branches_id_seq', 2, true);


--
-- TOC entry 3612 (class 0 OID 0)
-- Dependencies: 237
-- Name: customers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.customers_id_seq', 2, true);


--
-- TOC entry 3613 (class 0 OID 0)
-- Dependencies: 215
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 3614 (class 0 OID 0)
-- Dependencies: 216
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 40, true);


--
-- TOC entry 3615 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 7, true);


--
-- TOC entry 3616 (class 0 OID 0)
-- Dependencies: 218
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);


--
-- TOC entry 3617 (class 0 OID 0)
-- Dependencies: 219
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- TOC entry 3618 (class 0 OID 0)
-- Dependencies: 239
-- Name: product_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_categories_id_seq', 2, true);


--
-- TOC entry 3619 (class 0 OID 0)
-- Dependencies: 233
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 17, true);


--
-- TOC entry 3620 (class 0 OID 0)
-- Dependencies: 220
-- Name: role_menu_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.role_menu_access_id_seq', 95, true);


--
-- TOC entry 3621 (class 0 OID 0)
-- Dependencies: 221
-- Name: user_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_groups_id_seq', 4, true);


--
-- TOC entry 3622 (class 0 OID 0)
-- Dependencies: 222
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1106, true);


--
-- TOC entry 3417 (class 2606 OID 16657)
-- Name: branches branches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_pkey PRIMARY KEY (id);


--
-- TOC entry 3419 (class 2606 OID 16666)
-- Name: customers customers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (id);


--
-- TOC entry 3389 (class 2606 OID 16608)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 3391 (class 2606 OID 16606)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 3397 (class 2606 OID 16614)
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- TOC entry 3399 (class 2606 OID 16616)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 3401 (class 2606 OID 16618)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 3404 (class 2606 OID 16621)
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- TOC entry 3406 (class 2606 OID 16626)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 3408 (class 2606 OID 16624)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 3421 (class 2606 OID 16675)
-- Name: product_categories product_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_categories
    ADD CONSTRAINT product_categories_pkey PRIMARY KEY (id);


--
-- TOC entry 3415 (class 2606 OID 16646)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- TOC entry 3393 (class 2606 OID 16610)
-- Name: group_menu_access role_menu_access_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_menu_access
    ADD CONSTRAINT role_menu_access_pkey PRIMARY KEY (id);


--
-- TOC entry 3395 (class 2606 OID 16612)
-- Name: groups user_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT user_groups_pkey PRIMARY KEY (id, code);


--
-- TOC entry 3411 (class 2606 OID 16628)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 3413 (class 2606 OID 16630)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3402 (class 1259 OID 16619)
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- TOC entry 3409 (class 1259 OID 16622)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 3423 (class 2606 OID 16681)
-- Name: products fk_category; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES public.product_categories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3422 (class 2606 OID 16631)
-- Name: menus menus_parent_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES public.menus(id) ON DELETE CASCADE;


-- Completed on 2024-12-15 20:31:56 WIB

--
-- PostgreSQL database dump complete
--

