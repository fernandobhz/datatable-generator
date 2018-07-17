<?php 
namespace Fernandobhz;

Class DatatableGenerator {
	
	public static function code($table, $title) {
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
							class="table table-striped table-bordered data-table-new"
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