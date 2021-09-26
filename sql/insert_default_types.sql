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

--
-- Data for Name: agegroups; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.agegroups (agegroupid, agegroup, agestart, ageend) FROM stdin;
1	18 - 21	18	21
2	21 - 27	21	27
3	27 - 32	27	32
4	32 - 41	32	41
5	41 - 54	41	54
6	54 - 66	54	66
7	66 - 79	66	79
8	79+	79	200
\.


--
-- Data for Name: genders; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.genders (genderid, gendersingular, genderplural) FROM stdin;
2	Woman	Women
1	Man	Men
3	Trans* Person	Trans* People
\.


--
-- Data for Name: images; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.images (imageid, image) FROM stdin;
\.


--
-- Data for Name: visibility; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.visibility (visibilityid, visibility) FROM stdin;
1	Private
2	Matches
3	Public
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (userid, displayname, publickey, privatekey, dateofbirth, dateofbirthvisibilityid, genderid, gendervisibilityid, agevisibilityid, profileimageid, profileimagevisibilityid, location, displaylocation, displaylocationvisibilityid, seekinggendersvisibilityid, seekingagegroupsvisibilityid, aboutme, aboutmevisibilityid) FROM stdin;
\.


--
-- Data for Name: blocks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.blocks (blockid, blockfrom, blockto) FROM stdin;
\.


--
-- Data for Name: chats; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.chats (chatid, userid1, userid2) FROM stdin;
\.


--
-- Data for Name: logins; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.logins (userid, hash, username) FROM stdin;
\.


--
-- Data for Name: matches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.matches (matchid, useridfrom, useridto) FROM stdin;
\.


--
-- Data for Name: messages; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.messages (messageid, senderid, chatid, message) FROM stdin;
\.


--
-- Data for Name: seekingagegroups; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.seekingagegroups (seekingagegroupsid, userid, agegroupid) FROM stdin;
\.


--
-- Data for Name: seekinggenders; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.seekinggenders (seekinggendersid, userid, genderid) FROM stdin;
\.


--
-- Name: agegroups_agegroupid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.agegroups_agegroupid_seq', 8, true);


--
-- Name: blocks_blockid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.blocks_blockid_seq', 9, true);


--
-- Name: chats_chatid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.chats_chatid_seq', 37, true);


--
-- Name: gender_genderid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.gender_genderid_seq', 3, true);


--
-- Name: images_imageid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.images_imageid_seq', 31, true);


--
-- Name: matches_matchid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.matches_matchid_seq', 43, true);


--
-- Name: messages_messageid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.messages_messageid_seq', 171, true);


--
-- Name: seekingagegroups_seekingagegroupsid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.seekingagegroups_seekingagegroupsid_seq', 211, true);


--
-- Name: seekinggenders_seekinggendersid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.seekinggenders_seekinggendersid_seq', 200, true);


--
-- Name: users_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_userid_seq', 132, true);


--
-- Name: visibility_visibilityid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.visibility_visibilityid_seq', 3, true);


--
-- PostgreSQL database dump complete
--

