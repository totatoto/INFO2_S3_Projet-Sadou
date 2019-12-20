INSERT INTO public.flux_rss(link) VALUES ('https://www.cert.ssi.gouv.fr/feed/');
INSERT INTO public.flux_rss(link) VALUES ('https://rssbox.herokuapp.com/twitter/4436776155/hack2g2?include_rts=1');
INSERT INTO public.flux_rss(link) VALUES ('https://www.zdnet.fr/blogs/cybervigilance/rss/');
INSERT INTO public.flux_rss(link) VALUES ('https://www.silicon.fr/feed');
INSERT INTO public.flux_rss(link) VALUES ('https://www.datasecuritybreach.fr/feed/');
INSERT INTO public.flux_rss(link) VALUES ('https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml');

INSERT INTO public.page_links_categs(numpage, link_flux_rss, name_category)	VALUES (1, 'https://www.datasecuritybreach.fr/feed/', 'Cybersécurité');
INSERT INTO public.page_links_categs(numpage, link_flux_rss, name_category)	VALUES (1, 'https://www.silicon.fr/feed', 'Cybersécurité');
INSERT INTO public.page_links_categs(numpage, link_flux_rss, name_category)	VALUES (1, 'https://www.zdnet.fr/blogs/cybervigilance/rss/', 'Firewall');
INSERT INTO public.page_links_categs(numpage, link_flux_rss)	VALUES (1, 'https://www.cert.ssi.gouv.fr/feed/');
