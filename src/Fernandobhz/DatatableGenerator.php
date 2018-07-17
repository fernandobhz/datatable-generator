<?php 
namespace Fernandobhz;

Class DatatableGenerator {
	
	public static function dtable($table, $title) {
		self::code($table, $title, 'data-table');
	}
	
	public static function dlist($table, $title) {
		self::code($table, $title, 'data-table-list');
	}
	
	public static function dnew($table, $title) {
		self::code($table, $title, 'data-table-new');
	}
	
	private static function code($table, $title, $cls) {
		$table = json_encode(json_decode($table)); 
		$cols = array_keys($rows[0]);
		$rows = [];
		foreach ( $table as $x ) $rows[] = array_values($x);
		:?>
			<div>
				<div class=row>
					<div class=row style="text-transform: uppercase; text-align: center">
						<?=$title?>
					</div>
				</div>
				<div class=row>
					<div class=col>
						<table 
							id="mytable" 
							class="table table-striped table-bordered $cls"
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
					</div>
				</div>
			</div>
		<?php		
	}
}
?>