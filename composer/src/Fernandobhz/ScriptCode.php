<script>
	$(function() {
		<?php if ( $verb == 'data-table' ) { ?>
		$('.data-table-<?=$cssclass?>').each(function(index, elm) {
			var x = {
				dom: 'rt<".pesqdt-<?=$cssclass?>"f><".btnsdt-<?=$cssclass?>"B><"dtextra-<?=$cssclass?>">p'
				, buttons: [ 'copy', 'csv', 'excel', 'print']
			}
			
			var ss = $(elm).attr("data-server-side");
			if ( ss ) {
				x.processing = true;
				x.serverSide = true;
				x.ajax = location.pathname + ss;
			}
			
			var cns = $(elm).attr("data-columns-name");
			if ( cns )  {
				cns = atob(cns);
				cns = JSON.parse(cns);
				
				x.columns = [];
				for ( key in cns ) {
					x.columns.push({ 
						name: key
						, data: key
						, title: cns[key]
					});
				}
			}
			
			$(elm).DataTable(x);
		});
		<?php } ?>
		
		<?php if ( $verb == 'data-table-list' ) { ?>
		$('.data-table-list-<?=$cssclass?>').each(function(index, elm) {
			var x = {
				dom: 'rt<".pesqdt-<?=$cssclass?>"f><"dtextra-<?=$cssclass?>">p'
			}
			
			var ss = $(elm).attr("data-server-side");
			if ( ss ) {
				x.processing = true;
				x.serverSide = true;
				x.ajax = location.pathname + ss;
			}
			
			var cns = $(elm).attr("data-columns-name");
			if ( cns )  {
				cns = atob(cns);
				cns = JSON.parse(cns);
				
				x.columns = [];
				for ( key in cns ) {
					x.columns.push({ 
						name: key
						, data: key
						, title: cns[key]
					});
				}
			}
			
			$(elm).DataTable(x);
		});
		<?php } ?>

		
		<?php if ( $verb == 'data-table-new' ) { ?>
		$(".data-table-new-<?=$cssclass?>").each(function(index, elm) {
			var nm = $(elm).attr("data-name");
			if ( ! nm ) {
				alertify.notify("data-name sao necessários no elemento: " + elm.id);
				return;
			}
			
			var ac = $(elm).attr("data-action");
			if ( ! ac ) {
				alertify.notify("data-action sao necessários no elemento: " + elm.id);
				return;
			}

			var x = {
				dom: 'rt<".pesqdt-<?=$cssclass?>"f><".btnsdt-<?=$cssclass?>"B><".dtnovo-<?=$cssclass?>' + nm + '">p'
				, buttons: [ 'copy', 'csv', 'excel', 'print']
			}
			
			var ss = $(elm).attr("data-server-side");
			if ( ss ) {
				x.processing = true;
				x.serverSide = true;
				x.ajax = location.pathname + ss;
			}
			
			var cns = $(elm).attr("data-columns-name");
			if ( cns )  {
				cns = atob(cns);
				cns = JSON.parse(cns);
				
				x.columns = [];
				for ( key in cns ) {
					x.columns.push({ 
						name: key
						, data: key
						, title: cns[key]
					});
				}
			}
			
			$('.data-table-new-<?=$cssclass?>').DataTable(x);
			
			$(".dtnovo-<?=$cssclass?>" + nm).html('<button class="btn btn-default" onclick="location=\'/' + ac + '/add\'"><span><i class="fa fa-plus"></i> ' + nm + '</span></button>');
			$(".dtnovo-<?=$cssclass?>" + nm).addClass('dtnovo-<?=$cssclass?>');
		});
		<?php } ?>
	});
</script>
