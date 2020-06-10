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
  "AF": 16.63,
  "AL": 11.58,
  "DZ": 158.97,
  "AO": 85.81,
  "AG": 1.1,
  "AR": 351.02,
  "AM": 8.83,
  "AU": 1219.72,
  "AT": 366.26,
  "AZ": 52.17,
  "BS": 7.54,
  "BH": 21.73,
  "BD": 105.4,
  "BB": 3.96,
  "BY": 52.89,
  "BE": 461.33,
  "BZ": 1.43,
  "BJ": 6.49,
  "BT": 1.4,
  "BO": 19.18,
  "BA": 16.2,
  "BW": 12.5,
  "BR": 2023.53,
  "BN": 11.96,
  "BG": 44.84,
  "BF": 8.67,
  "BI": 1.47,
  "KH": 11.36,
  "CM": 21.88,
  "CA": 1563.66,
  "CV": 1.57,
  "CF": 2.11,
  "TD": 7.59,
  "CL": 199.18,
  "CN": 5745.13,
  "CO": 283.11,
  "KM": 0.56,
  "CD": 12.6,
  "CG": 11.88,
  "CR": 35.02,
  "CI": 22.38,
  "HR": 59.92,
  "CY": 22.75,
  "CZ": 195.23,
  "DK": 304.56,
  "DJ": 1.14,
  "DM": 0.38,
  "DO": 50.87,
  "EC": 61.49,
  "EG": 216.83,
  "SV": 21.8,
  "GQ": 14.55,
  "ER": 2.25,
  "EE": 19.22,
  "ET": 30.94,
  "FJ": 3.15,
  "FI": 231.98,
  "FR": 2555.44,
  "GA": 12.56,
  "GM": 1.04,
  "GE": 11.23,
  "DE": 3305.9,
  "GH": 18.06,
  "GR": 305.01,
  "GD": 0.65,
  "GT": 40.77,
  "GN": 4.34,
  "GW": 0.83,
  "GY": 2.2,
  "HT": 6.5,
  "HN": 15.34,
  "HK": 226.49,
  "HU": 132.28,
  "IS": 12.77,
  "IN": 1430.02,
  "ID": 695.06,
  "IR": 337.9,
  "IQ": 84.14,
  "IE": 204.14,
  "IL": 201.25,
  "IT": 2036.69,
  "JM": 13.74,
  "JP": 5390.9,
  "JO": 27.13,
  "KZ": 129.76,
  "KE": 32.42,
  "KI": 0.15,
  "KR": 986.26,
  "UNDEFINED": 5.73,
  "KW": 117.32,
  "KG": 4.44,
  "LA": 6.34,
  "LV": 23.39,
  "LB": 39.15,
  "LS": 1.8,
  "LR": 0.98,
  "LY": 77.91,
  "LT": 35.73,
  "LU": 52.43,
  "MK": 9.58,
  "MG": 8.33,
  "MW": 5.04,
  "MY": 218.95,
  "MV": 1.43,
  "ML": 9.08,
  "MT": 7.8,
  "MR": 3.49,
  "MU": 9.43,
  "MX": 1004.04,
  "MD": 5.36,
  "MN": 5.81,
  "ME": 3.88,
  "MA": 91.7,
  "MZ": 10.21,
  "MM": 35.65,
  "NA": 11.45,
  "NP": 15.11,
  "NL": 770.31,
  "NZ": 138,
  "NI": 6.38,
  "NE": 5.6,
  "NG": 206.66,
  "NO": 413.51,
  "OM": 53.78,
  "PK": 174.79,
  "PA": 27.2,
  "PG": 8.81,
  "PY": 17.17,
  "PE": 153.55,
  "PH": 189.06,
  "PL": 438.88,
  "PT": 223.7,
  "QA": 126.52,
  "RO": 158.39,
  "RU": 1476.91,
  "RW": 5.69,
  "WS": 0.55,
  "ST": 0.19,
  "SA": 434.44,
  "SN": 12.66,
  "RS": 38.92,
  "SC": 0.92,
  "SL": 1.9,
  "SG": 217.38,
  "SK": 86.26,
  "SI": 46.44,
  "SB": 0.67,
  "ZA": 354.41,
  "ES": 1374.78,
  "LK": 48.24,
  "KN": 0.56,
  "LC": 1,
  "VC": 0.58,
  "SD": 65.93,
  "SR": 3.3,
  "SZ": 3.17,
  "SE": 444.59,
  "CH": 522.44,
  "SY": 59.63,
  "TW": 426.98,
  "TJ": 5.58,
  "TZ": 22.43,
  "TH": 312.61,
  "TL": 0.62,
  "TG": 3.07,
  "TO": 0.3,
  "TT": 21.2,
  "TN": 43.86,
  "TR": 729.05,
  "TM": 0,
  "UG": 17.12,
  "UA": 136.56,
  "AE": 239.65,
  "GB": 2258.57,
  "US": 14624.18,
  "UY": 40.71,
  "UZ": 37.72,
  "VU": 0.72,
  "VE": 285.21,
  "VN": 101.99,
  "YE": 30.02,
  "ZM": 15.69,
  "ZW": 5.57
};