#
# Modifying 'sys_category' table
#
CREATE TABLE sys_category (
	tx_cookieconsentplus_iscookiesdependent smallint(5) DEFAULT 0 NOT NULL,
	tx_cookieconsentplus_conditiontype varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_statisticscondition varchar(20) DEFAULT '' NOT NULL,
	tx_cookieconsentplus_marketingcondition varchar(20) DEFAULT '' NOT NULL,
);
