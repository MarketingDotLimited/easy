
	$("#{$table.id}")
        
{literal}        
        .dataTable( {
                "bProcessing": true,
                "searching": true,
                "bServerSide": true,
{/literal}                
                'sAjaxSource': "{$table.data}",


{literal}
            "fnServerData": function ( sSource, aoData, fnCallback ) {
            
{/literal}
        {if $dt.filters.date == true}
        
             {* use aoData.push to send extra variables to an external php file *}
             
        
                   aoData.push( {literal} { {/literal} "name": "FromDate", "value": $("#FromDate_{$dt.id}").val() {literal} } {/literal}  );
                      aoData.push( {literal} { {/literal} "name": "ToDate", "value": $("#ToDate_{$dt.id}").val() {literal} } {/literal} ); 
        
        {/if}
        
        
        {literal}
                    $.ajax( {
			"dataType": 'json', 
			"type": "POST", 
			"url": sSource, 
			"data": aoData, 
                        "success": fnCallback

                    } );},


	} );

        
        {/literal}

  
