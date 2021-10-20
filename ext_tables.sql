#
# Modifying 'pages' table
#
CREATE TABLE pages (
	tx_cookieconsentplus_iscookiesdependent smallint(5) DEFAULT 0 NOT NULL,
	tx_cookieconsentplus_conditiontype varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_mandatorycondition varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_statisticscondition varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_marketingcondition varchar(20) DEFAULT '' NOT NULL,
);

#
# Modifying 'tt_content' table
#
CREATE TABLE tt_content (
	tx_cookieconsentplus_iscookiesdependent smallint(5) DEFAULT 0 NOT NULL,
	tx_cookieconsentplus_conditiontype varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_mandatorycondition varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_statisticscondition varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_marketingcondition varchar(20) DEFAULT '' NOT NULL,
);
