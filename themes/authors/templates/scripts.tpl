

{foreach from=$hooks.pre_scripts item=foo}
 {include file=$foo}
{/foreach}
 <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
 <script type="text/javascript" charset="utf8" src="assists/main/js/jquery-ui/jquery-ui.min.js"></script>

 
{foreach from=$hooks.post_scripts item=foo}
 {include file=$foo}
{/foreach}