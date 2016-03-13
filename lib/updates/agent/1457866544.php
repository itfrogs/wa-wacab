<?php
	$model = new waModel();
	$model->query('CREATE TABLE IF NOT EXISTS wacab_areport (
  rid int(32) NOT NULL,
  sdate date NOT NULL,
  edate date NOT NULL,
  sum varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  paydate date DEFAULT NULL,
  html text COLLATE utf8_unicode_ci,
  PRIMARY KEY (rid)
)');
