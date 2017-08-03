<footer>

<div class="btm-foot">
<div class="left"> </div>
<div class="right">   <i class="fa fa-heart"></i> </div>
</div>
</footer>

{foreach from=$hooks.post_body item=foo}
 {include file=$foo}
{/foreach}

</body>
</html>