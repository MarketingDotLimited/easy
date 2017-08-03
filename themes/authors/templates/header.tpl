<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

{include file="styles.tpl"}
{include file="scripts.tpl"}



</head>


<body>
{foreach from=$hooks.pre_body item=foo}
 {include file=$foo}
{/foreach}


