{foreach from=$hooks.pre_styles item=foo}
 {include file=$foo}
{/foreach}
 <link rel="stylesheet" type="text/css" href="assists/main/js/jquery-ui/jquery-ui.min.css">
{foreach from=$hooks.post_styles item=foo}
 {include file=$foo}
{/foreach}
