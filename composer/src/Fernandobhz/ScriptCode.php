<script>
	$(function() {
		var rand = '<?=$opts['rand'];?>';
		
		$('.dtgen-' + rand).each(function(index, elm) {
			var domprocessing 	= 'r';
			var domtable 		= 't';
			var domsearch 		= '<".dtgen-search-' +  rand + '"f>';
			var domexport 		= '<".dtgen-export-' + rand + '"B>';
			var domnew 			= '<".dtgen-new-' + rand + '">';
			var dompaging 		= 'p';
			var buttons			= [ 'copy', 'csv', 'excel', 'print'];

			var issearch 		= $(elm).attr("data-dtgen-search");
			var isexport	 	= $(elm).attr("data-dtgen-export");
			var isnew 			= $(elm).attr("data-dtgen-new");
			var ispaging 		= $(elm).attr("data-dtgen-paging");

			var dataname 		= $(elm).attr("data-dtgen-name");
			var dataaction 		= $(elm).attr("data-dtgen-action");

			var serverside 		= $(elm).attr("data-dtgen-server-side");
			var columnsname		= $(elm).attr("data-dtgen-columns-name");

			var dom
				= domprocessing
				+ domtable
				+ ( issearch 	? domsearch	: "" )
				+ ( isexport 	? domexport	: "" )
				+ ( isnew 		? domnew	: "" )
				+ ( ispaging 	? dompaging	: "" )
			;

			var x = { dom: dom, buttons: buttons }

			if ( serverside ) {
				x.processing = true;
				x.serverSide = true;
				x.ajax = location.pathname + serverside;
			}

			if ( columnsname )  {
				var json = atob(columnsname);
				var cols = JSON.parse(json);

				x.columns = [];
				for ( key in cols ) {
					x.columns.push({
						name: key
						, data: key
						, title: cols[key]
					});
				}
			}

			window.xpto = JSON.stringify(x, null, 4);
			console.log(xpto);
			debugger;
			
			$(elm).DataTable(x);
			if ( isnew )
				$('.dtgen-new-' + rand).html('<button class="btn btn-default" onclick="location=\'/' + dataaction + '\'"><span><i class="fa fa-plus"></i> ' + dataname + '</span></button>');
		});
	});
</script>
