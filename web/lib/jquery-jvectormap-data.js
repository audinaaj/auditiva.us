/*
--------------------------
Codes
--------------------------
1	BD	Bangladesh
2	BE	Belgium
3	BF	Burkina Faso
4	BG	Bulgaria
5	BA	Bosnia and Herz.
6	BN	Brunei
7	BO	Bolivia
8	JP	Japan
9	BI	Burundi
10	BJ	Benin
11	BT	Bhutan
12	JM	Jamaica
13	BW	Botswana
14	BR	Brazil
15	BS	Bahamas
16	BY	Belarus
17	BZ	Belize
18	RU	Russia
19	RW	Rwanda
20	RS	Serbia
21	LT	Lithuania
22	LU	Luxembourg
23	LR	Liberia
24	RO	Romania
25	GW	Guinea-Bissau
26	GT	Guatemala
27	GR	Greece
28	GQ	Eq. Guinea
29	GY	Guyana
30	GE	Georgia
31	GB	United Kingdom
32	GA	Gabon
33	GN	Guinea
34	GM	Gambia
35	GL	Greenland
36	KW	Kuwait
37	GH	Ghana
38	OM	Oman
39	_1	Somaliland
40	_0	Kosovo
41	JO	Jordan
42	HR	Croatia
43	HT	Haiti
44	HU	Hungary
45	HN	Honduras
46	PR	Puerto Rico
47	PS	Palestine
48	PT	Portugal
49	PY	Paraguay
50	PA	Panama
51	PG	Papua New Guinea
52	PE	Peru
53	PK	Pakistan
54	PH	Philippines
55	PL	Poland
56	-99	N. Cyprus
57	ZM	Zambia
58	EH	W. Sahara
59	EE	Estonia
60	EG	Egypt
61	ZA	South Africa
62	EC	Ecuador
63	AL	Albania
64	AO	Angola
65	KZ	Kazakhstan
66	ET	Ethiopia
67	ZW	Zimbabwe
68	ES	Spain
69	ER	Eritrea
70	ME	Montenegro
71	MD	Moldova
72	MG	Madagascar
73	MA	Morocco
74	UZ	Uzbekistan
75	MM	Myanmar
76	ML	Mali
77	MN	Mongolia
78	MK	Macedonia
79	MW	Malawi
80	MR	Mauritania
81	UG	Uganda
82	MY	Malaysia
83	MX	Mexico
84	VU	Vanuatu
85	FR	France
86	FI	Finland
87	FJ	Fiji
88	FK	Falkland Is.
89	NI	Nicaragua
90	NL	Netherlands
91	NO	Norway
92	NA	Namibia
93	NC	New Caledonia
94	NE	Niger
95	NG	Nigeria
96	NZ	New Zealand
97	NP	Nepal
98	CI	Côte d'Ivoire
99	CH	Switzerland
100	CO	Colombia
101	CN	China
102	CM	Cameroon
103	CL	Chile
104	CA	Canada
105	CG	Congo
106	CF	Central African Rep.
107	CD	Dem. Rep. Congo
108	CZ	Czech Rep.
109	CY	Cyprus
110	CR	Costa Rica
111	CU	Cuba
112	SZ	Swaziland
113	SY	Syria
114	KG	Kyrgyzstan
115	KE	Kenya
116	SS	S. Sudan
117	SR	Suriname
118	KH	Cambodia
119	SV	El Salvador
120	SK	Slovakia
121	KR	Korea
122	SI	Slovenia
123	KP	Dem. Rep. Korea
124	SO	Somalia
125	SN	Senegal
126	SL	Sierra Leone
127	SB	Solomon Is.
128	SA	Saudi Arabia
129	SE	Sweden
130	SD	Sudan
131	DO	Dominican Rep.
132	DJ	Djibouti
133	DK	Denmark
134	DE	Germany
135	YE	Yemen
136	AT	Austria
137	DZ	Algeria
138	US	United States
139	LV	Latvia
140	UY	Uruguay
141	LB	Lebanon
142	LA	Lao PDR
143	TW	Taiwan
144	TT	Trinidad and Tobago
145	TR	Turkey
146	LK	Sri Lanka
147	TN	Tunisia
148	TL	Timor-Leste
149	TM	Turkmenistan
150	TJ	Tajikistan
151	LS	Lesotho
152	TH	Thailand
153	TF	Fr. S. Antarctic Lands
154	TG	Togo
155	TD	Chad
156	LY	Libya
157	AE	United Arab Emirates
158	VE	Venezuela
159	AF	Afghanistan
160	IQ	Iraq
161	IS	Iceland
162	IR	Iran
163	AM	Armenia
164	IT	Italy
165	VN	Vietnam
166	AR	Argentina
167	AU	Australia
168	IL	Israel
169	IN	India
170	TZ	Tanzania
171	AZ	Azerbaijan
172	IE	Ireland
173	ID	Indonesia
174	UA	Ukraine
175	QA	Qatar
176	MZ	Mozambique
--------------------------
*/

var gdpData = {
  "_0": 1000,  // Kosovo (temp code is XK)
  "_1": 1000,  // Somaliland
  "AF": 1000,
  "AL": 1000,
  "DZ": 1000,
  "AO": 1000,
  "AG": 1000,
  "AR": 15000,
  "AM": 1000,
  "AU": 1000,
  "AT": 1000,
  "AZ": 1000,
  "BS": 1000,
  "BH": 1000,
  "BD": 1000,
  "BB": 1000,
  "BY": 1000,
  "BE": 1000,
  "BZ": 1000,
  "BJ": 1000,
  "BT": 1000,
  "BO": 15000,
  "BA": 1000,
  "BW": 1000,
  "BR": 1000,
  "BN": 1000,
  "BG": 1000,
  "BF": 1000,
  "BI": 1000,
  "KH": 1000,
  "CM": 1000,
  "CA": 1000,
  "CV": 1000,
  "CF": 1000,
  "CU": 1000,
  "TD": 1000,
  "CL": 15000,
  "CN": 1000,
  "CO": 15000,
  "KM": 1000,
  "CD": 1000,
  "CG": 1000,
  "CR": 15000,
  "CI": 1000,
  "HR": 1000,
  "CY": 1000,
  "CZ": 1000,
  "DK": 1000,
  "DJ": 1000,
  "DM": 1000,
  "DO": 1000,
  "EC": 1000,
  "EG": 15000,
  "EH": 1000,
  "SV": 1000,
  "GQ": 1000,
  "ER": 1000,
  "EE": 1000,
  "ET": 1000,
  "FJ": 1000,
  "FK": 1000,
  "FI": 1000,
  "FR": 1000,
  "GA": 1000,
  "GM": 1000,
  "GE": 1000,
  "DE": 1000,
  "GH": 1000,
  "GR": 15000,
  "GD": 1000,
  "GL": 1000,
  "GT": 15000,
  "GN": 1000,
  "GW": 1000,
  "GY": 1000,
  "HT": 1000,
  "HN": 1000,
  "HK": 1000,
  "HU": 1000,
  "IS": 1000,
  "IN": 15000,
  "ID": 1000,
  "IR": 15000,
  "IQ": 1000,
  "IE": 15000,
  "IL": 1000,
  "IT": 1000,
  "JM": 1000,
  "JP": 1000,
  "JO": 1000,
  "KZ": 1000,
  "KE": 1000,
  "KI": 1000,
  "KP": 1000,
  "KR": 15000,
  "UNDEFINED": 1000,
  "KW": 1000,
  "KG": 1000,
  "LA": 1000,
  "LV": 1000,
  "LB": 1000,
  "LS": 1000,
  "LR": 1000,
  "LY": 1000,
  "LT": 1000,
  "LU": 1000,
  "MK": 1000,
  "MG": 1000,
  "MW": 1000,
  "MY": 1000,
  "MV": 1000,
  "ML": 1000,
  "MT": 1000,
  "MR": 1000,
  "MU": 1000,
  "MX": 15000,
  "MD": 1000,
  "MN": 1000,
  "ME": 1000,
  "MA": 15000,
  "MZ": 1000,
  "MM": 1000,
  "NA": 1000,
  "NC": 1000,
  "NP": 1000,
  "NL": 1000,
  "NZ": 1000,
  "NI": 1000,
  "NE": 1000,
  "NG": 1000,
  "NO": 1000,
  "OM": 1000,
  "PK": 1000,
  "PA": 15000,
  "PG": 1000,
  "PR": 1000,
  "PY": 1000,
  "PE": 15000,
  "PH": 1000,
  "PL": 15000,
  "PT": 1000,
  "QA": 1000,
  "RO": 1000,
  "RU": 15000,
  "RW": 1000,
  "WS": 1000,
  "ST": 1000,
  "SA": 1000,
  "SN": 1000,
  "RS": 1000,
  "SC": 1000,
  "SL": 1000,
  "SG": 15000,
  "SK": 1000,
  "SI": 1000,
  "SB": 1000,
  "ZA": 1000,
  "ES": 15000,
  "LK": 1000,
  "KN": 1000,
  "LC": 1000,
  "VC": 1000,
  "SD": 1000,
  "SR": 1000,
  "SZ": 1000,
  "SE": 1000,
  "CH": 1000,
  "SO": 1000,
  "SS": 1000,
  "SY": 1000,
  "TW": 1000,
  "TJ": 1000,
  "TZ": 1000,
  "TH": 1000,
  "TL": 1000,
  "TG": 1000,
  "TO": 1000,
  "TT": 1000,
  "TN": 1000,
  "TR": 15000,
  "TM": 1000,
  "UG": 1000,
  "UA": 1000,
  "AE": 1000,
  "GB": 15000,
  "US": 15000,
  "UY": 1000,
  "UZ": 1000,
  "VU": 1000,
  "VE": 1000,
  "VN": 1000,
  "YE": 1000,
  "ZM": 1000,
  "ZW": 1000
};