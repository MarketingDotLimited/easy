             
           {if $modulePath }    
                {foreach from=$dt.tables key=k item=v}       
                   {include file= $modulePath.datatables.theme|cat:"table.tpl" table=$v} 
                {/foreach}
            {/if}
