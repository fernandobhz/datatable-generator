<?php 
namespace Fernandobhz;

Class DatatableGenerator {

	public static function test() {
		echo ("hello datatable generator");
	}
	
	public static function dtable($table, $cols) {
		self::code($table, $cols, 'data-table');
	}
	
	public static function dlist($table, $cols) {
		self::code($table, $cols, 'data-table-list');
	}
	
	public static function dnew($table, $cols) {
		self::code($table, $cols, 'data-table-new');
	}

	private static function head() {
	:?>
		$(function() {
			$('.data-table').DataTable({
				dom: 'rt<".pesqdt"f><".btnsdt"B><"dtextra">p'
				, buttons: [ 'copy', 'csv', 'excel', 'print']
			});
			
			$('.data-table-list').DataTable({
				dom: 'rt<".pesqdt"f><"dtextra">p'
			});
			
			$(".data-table-novo").each(function(index, elm) {
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
				
				
				$('.data-table-novo').DataTable({
					dom: 'rt<".pesqdt"f><".btnsdt"B><".dtnovo' + nm + '">p'
					, buttons: [ 'copy', 'csv', 'excel', 'print']
				});

				$(".dtnovo" + nm).html('<button class="btn btn-default" onclick="location=\'/' + ac + '/add\'"><span><i class="fa fa-plus"></i> ' + nm + '</span></button>');
				$(".dtnovo" + nm).addClass('dtnovo');
			});
		});
	<?php
	}
	
	private static function code($table, $cols, $cls) {
		$table = (array)json_decode(json_encode($table));
		foreach ( $table as $key => $value ) $table[$key] = (array)$value;
		
		$rows = []; foreach ( $table as $x ) $rows[] = array_values($x);
		//var_dump($cols); die();
		?>
			<table 
				id="mytable" 
				class="table table-striped table-bordered <?=$cls?>"
				data-name="Pessoas" 
				data-action="add">				
				<thead>
					<tr>
						<?php foreach ( $cols as $col ): ?>
						<th>
							<?=$col?>
						</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ): ?>
					<tr>
						<?php foreach ( $row as $val): ?>
						<td>
							<?=$val?>
						</td>
						<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php		
	}
}
?>