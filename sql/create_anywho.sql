--
-- PostgreSQL database dump
--

-- Dumped from database version 13.3 (Ubuntu 13.3-1.pgdg20.04+1)
-- Dumped by pg_dump version 13.3 (Ubuntu 13.3-1.pgdg20.04+1)

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: agegroups; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.agegroups (
    agegroupid integer NOT NULL,
    agegroup text NOT NULL,
    agestart integer NOT NULL,
    ageend integer NOT NULL
);


--
-- Name: agegroups_agegroupid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.agegroups_agegroupid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: agegroups_agegroupid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.agegroups_agegroupid_seq OWNED BY public.agegroups.agegroupid;


--
-- Name: blocks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.blocks (
    blockid integer NOT NULL,
    blockfrom integer NOT NULL,
    blockto integer NOT NULL
);


--
-- Name: blocks_blockid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.blocks_blockid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: blocks_blockid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.blocks_blockid_seq OWNED BY public.blocks.blockid;


--
-- Name: chats; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.chats (
    chatid integer NOT NULL,
    userid1 integer NOT NULL,
    userid2 integer NOT NULL
);


--
-- Name: chats_chatid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.chats_chatid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: chats_chatid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.chats_chatid_seq OWNED BY public.chats.chatid;


--
-- Name: genders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.genders (
    genderid integer NOT NULL,
    gendersingular text NOT NULL,
    genderplural text
);


--
-- Name: gender_genderid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.gender_genderid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: gender_genderid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.gender_genderid_seq OWNED BY public.genders.genderid;


--
-- Name: images; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.images (
    imageid integer NOT NULL,
    image text NOT NULL
);


--
-- Name: images_imageid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.images_imageid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: images_imageid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.images_imageid_seq OWNED BY public.images.imageid;


--
-- Name: logins; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.logins (
    userid integer NOT NULL,
    hash text NOT NULL,
    username text NOT NULL
);


--
-- Name: matches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.matches (
    matchid integer NOT NULL,
    useridfrom integer NOT NULL,
    useridto integer NOT NULL
);


--
-- Name: matches_matchid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.matches_matchid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: matches_matchid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.matches_matchid_seq OWNED BY public.matches.matchid;


--
-- Name: messages; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.messages (
    messageid integer NOT NULL,
    senderid integer NOT NULL,
    chatid integer NOT NULL,
    message text NOT NULL
);


--
-- Name: messages_messageid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.messages_messageid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: messages_messageid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.messages_messageid_seq OWNED BY public.messages.messageid;


--
-- Name: seekingagegroups; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seekingagegroups (
    seekingagegroupsid integer NOT NULL,
    userid integer NOT NULL,
    agegroupid integer NOT NULL
);


--
-- Name: seekingagegroups_seekingagegroupsid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.seekingagegroups_seekingagegroupsid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: seekingagegroups_seekingagegroupsid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.seekingagegroups_seekingagegroupsid_seq OWNED BY public.seekingagegroups.seekingagegroupsid;


--
-- Name: seekinggenders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seekinggenders (
    seekinggendersid integer NOT NULL,
    userid integer NOT NULL,
    genderid integer NOT NULL
);


--
-- Name: seekinggenders_seekinggendersid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.seekinggenders_seekinggendersid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: seekinggenders_seekinggendersid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.seekinggenders_seekinggendersid_seq OWNED BY public.seekinggenders.seekinggendersid;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    userid integer NOT NULL,
    displayname text DEFAULT 'Anonymouse'::text NOT NULL,
    publickey text NOT NULL,
    privatekey text NOT NULL,
    dateofbirth date DEFAULT '1990-01-01'::date NOT NULL,
    dateofbirthvisibilityid integer DEFAULT 1 NOT NULL,
    genderid integer DEFAULT 1,
    gendervisibilityid integer DEFAULT 1 NOT NULL,
    agevisibilityid integer DEFAULT 1 NOT NULL,
    profileimageid integer,
    profileimagevisibilityid integer DEFAULT 1 NOT NULL,
    location point DEFAULT point(('-0.09'::numeric)::double precision, (51.5)::double precision) NOT NULL,
    displaylocation text DEFAULT 'Timbuktu'::text NOT NULL,
    displaylocationvisibilityid integer DEFAULT 1 NOT NULL,
    seekinggendersvisibilityid integer DEFAULT 1 NOT NULL,
    seekingagegroupsvisibilityid integer DEFAULT 1 NOT NULL,
    aboutme text DEFAULT 'Cool like you!'::text NOT NULL,
    aboutmevisibilityid integer DEFAULT 1 NOT NULL
);


--
-- Name: users_userid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_userid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_userid_seq OWNED BY public.users.userid;


--
-- Name: visibility; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.visibility (
    visibilityid integer NOT NULL,
    visibility text NOT NULL
);


--
-- Name: visibility_visibilityid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.visibility_visibilityid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: visibility_visibilityid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.visibility_visibilityid_seq OWNED BY public.visibility.visibilityid;


--
-- Name: agegroups agegroupid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.agegroups ALTER COLUMN agegroupid SET DEFAULT nextval('public.agegroups_agegroupid_seq'::regclass);


--
-- Name: blocks blockid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.blocks ALTER COLUMN blockid SET DEFAULT nextval('public.blocks_blockid_seq'::regclass);


--
-- Name: chats chatid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.chats ALTER COLUMN chatid SET DEFAULT nextval('public.chats_chatid_seq'::regclass);


--
-- Name: genders genderid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.genders ALTER COLUMN genderid SET DEFAULT nextval('public.gender_genderid_seq'::regclass);


--
-- Name: images imageid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.images ALTER COLUMN imageid SET DEFAULT nextval('public.images_imageid_seq'::regclass);


--
-- Name: matches matchid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.matches ALTER COLUMN matchid SET DEFAULT nextval('public.matches_matchid_seq'::regclass);


--
-- Name: messages messageid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.messages ALTER COLUMN messageid SET DEFAULT nextval('public.messages_messageid_seq'::regclass);


--
-- Name: seekingagegroups seekingagegroupsid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekingagegroups ALTER COLUMN seekingagegroupsid SET DEFAULT nextval('public.seekingagegroups_seekingagegroupsid_seq'::regclass);


--
-- Name: seekinggenders seekinggendersid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekinggenders ALTER COLUMN seekinggendersid SET DEFAULT nextval('public.seekinggenders_seekinggendersid_seq'::regclass);


--
-- Name: users userid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN userid SET DEFAULT nextval('public.users_userid_seq'::regclass);


--
-- Name: visibility visibilityid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visibility ALTER COLUMN visibilityid SET DEFAULT nextval('public.visibility_visibilityid_seq'::regclass);


--
-- Name: agegroups agegroups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.agegroups
    ADD CONSTRAINT agegroups_pkey PRIMARY KEY (agegroupid);


--
-- Name: blocks blocks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.blocks
    ADD CONSTRAINT blocks_pkey PRIMARY KEY (blockid);


--
-- Name: chats chats_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.chats
    ADD CONSTRAINT chats_pkey PRIMARY KEY (chatid);


--
-- Name: genders gender_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.genders
    ADD CONSTRAINT gender_pkey PRIMARY KEY (genderid);


--
-- Name: images images_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.images
    ADD CONSTRAINT images_pkey PRIMARY KEY (imageid);


--
-- Name: logins logins_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.logins
    ADD CONSTRAINT logins_pkey PRIMARY KEY (userid);


--
-- Name: matches matches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.matches
    ADD CONSTRAINT matches_pkey PRIMARY KEY (matchid);


--
-- Name: messages messages_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (messageid);


--
-- Name: seekingagegroups seekingagegroups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekingagegroups
    ADD CONSTRAINT seekingagegroups_pkey PRIMARY KEY (seekingagegroupsid);


--
-- Name: seekinggenders seekinggenders_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekinggenders
    ADD CONSTRAINT seekinggenders_pkey PRIMARY KEY (seekinggendersid);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


--
-- Name: visibility visibility_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visibility
    ADD CONSTRAINT visibility_pkey PRIMARY KEY (visibilityid);


--
-- Name: users_location_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX users_location_idx ON public.users USING gist (location);


--
-- Name: blocks blocks_blockfrom_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.blocks
    ADD CONSTRAINT blocks_blockfrom_fkey FOREIGN KEY (blockfrom) REFERENCES public.users(userid);


--
-- Name: blocks blocks_blockto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.blocks
    ADD CONSTRAINT blocks_blockto_fkey FOREIGN KEY (blockto) REFERENCES public.users(userid);


--
-- Name: chats chats_userid1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.chats
    ADD CONSTRAINT chats_userid1_fkey FOREIGN KEY (userid1) REFERENCES public.users(userid) NOT VALID;


--
-- Name: chats chats_userid2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.chats
    ADD CONSTRAINT chats_userid2_fkey FOREIGN KEY (userid2) REFERENCES public.users(userid) NOT VALID;


--
-- Name: matches matches_useridfrom_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.matches
    ADD CONSTRAINT matches_useridfrom_fkey FOREIGN KEY (useridfrom) REFERENCES public.users(userid) NOT VALID;


--
-- Name: matches matches_useridto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.matches
    ADD CONSTRAINT matches_useridto_fkey FOREIGN KEY (useridto) REFERENCES public.users(userid) NOT VALID;


--
-- Name: messages messages_chatid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_chatid_fkey FOREIGN KEY (chatid) REFERENCES public.chats(chatid);


--
-- Name: messages messages_senderid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_senderid_fkey FOREIGN KEY (senderid) REFERENCES public.users(userid);


--
-- Name: seekingagegroups seekingagegroups_agegroupid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekingagegroups
    ADD CONSTRAINT seekingagegroups_agegroupid_fkey FOREIGN KEY (agegroupid) REFERENCES public.agegroups(agegroupid);


--
-- Name: seekingagegroups seekingagegroups_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekingagegroups
    ADD CONSTRAINT seekingagegroups_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(userid);


--
-- Name: seekinggenders seekinggenders_genderid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekinggenders
    ADD CONSTRAINT seekinggenders_genderid_fkey FOREIGN KEY (genderid) REFERENCES public.genders(genderid);


--
-- Name: seekinggenders seekinggenders_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seekinggenders
    ADD CONSTRAINT seekinggenders_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(userid);


--
-- Name: logins userid; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.logins
    ADD CONSTRAINT userid FOREIGN KEY (userid) REFERENCES public.users(userid);


--
-- Name: users users_aboutmevisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_aboutmevisibilityid_fkey FOREIGN KEY (aboutmevisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_agevisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_agevisibilityid_fkey FOREIGN KEY (agevisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_dateofbirthvisibility_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_dateofbirthvisibility_fkey FOREIGN KEY (dateofbirthvisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_displaylocationvisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_displaylocationvisibilityid_fkey FOREIGN KEY (displaylocationvisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_gender_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_gender_fkey FOREIGN KEY (genderid) REFERENCES public.genders(genderid) NOT VALID;


--
-- Name: users users_gendervisibility_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_gendervisibility_fkey FOREIGN KEY (gendervisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_profileimageid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_profileimageid_fkey FOREIGN KEY (profileimageid) REFERENCES public.images(imageid) NOT VALID;


--
-- Name: users users_profileimagevisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_profileimagevisibilityid_fkey FOREIGN KEY (profileimagevisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_seekingagegroupsvisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_seekingagegroupsvisibilityid_fkey FOREIGN KEY (seekingagegroupsvisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- Name: users users_seekinggendersvisibilityid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_seekinggendersvisibilityid_fkey FOREIGN KEY (seekinggendersvisibilityid) REFERENCES public.visibility(visibilityid) NOT VALID;


--
-- PostgreSQL database dump complete
--

