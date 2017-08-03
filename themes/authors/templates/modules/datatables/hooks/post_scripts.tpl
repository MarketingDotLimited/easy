  <script type="text/javascript" charset="utf8" src= "{$modulePath.datatables.assists}DataTables/media/js/jquery.dataTables.min.js"></script>
  
  
  
  {literal}

<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {

{/literal}


        {if $date_filter == true}
                $.datepicker.regional[""].dateFormat = 'yy-mm-dd';
                $.datepicker.setDefaults($.datepicker.regional[""]);
        {/if}
            
 {foreach from=$data_tables key=k item=dt}  
     
                
                {foreach from=$dt.tables key=k item=v}       
                   {include file= $modulePath.datatables.theme|cat:"data_table_js.tpl" table=$v dt=$dt} 
                {/foreach}
                
                
                
   
                    
  
            
$("#FromDate_{$dt.id}").datepicker  {literal} ({   {/literal}
  maxDate: new Date( $('#ToDate').val() ),
  onSelect: function(dateText) {literal} {  {/literal}
  $("#ToDate_{$dt.id}").datepicker("option", "minDate", new Date(dateText));
 
      
      
  {foreach from=$dt.tables key=key_data_table item=item_data_table}      
  var table_{$item_data_table.id}_oTable = $("#{$item_data_table.id}").DataTable();    
  table_{$item_data_table.id}_oTable.draw();
  {/foreach}
      
 {literal}     
  }
});
 {/literal}

$("#ToDate_{$dt.id}").datepicker  {literal}   ({  {/literal}
  minDate: new Date( $('#FromDate').val() ),
  onSelect: function(dateText) {literal}  { {/literal}
  $("#FromDate_{$dt.id}").datepicker("option", "maxDate", new Date(dateText));
 
      
      
  {foreach from=$dt.tables key=key_data_table item=item_data_table}      
  var  table_{$item_data_table.id}_oTable = $("#{$item_data_table.id}").DataTable();    
  table_{$item_data_table.id}_oTable.draw();
  {/foreach}
      
 {literal}     
  }
});




} );


              {/literal}
{/foreach}


	</script>