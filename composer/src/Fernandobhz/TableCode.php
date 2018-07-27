<?php
	//echo "</template><pre>"; var_dump($opts); die();
	$attributes = $opts['attributes'];
	$classes = $opts['classes'];
	$cols = $opts['cols'];
	$values = $opts['values'];
	$serverSide = $opts['server-side'];
?>
<table <?=$attributes?> class="<?=$classes?>">
	<?php if ( $serverSide ) { ?>
		<thead>
		</thead>
		<tbody>
		</tbody>
	<?php } else { ?>
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
			<?php if ( ! $serverSide ) { ?>
				<?php foreach ( $values as $row ): ?>
				<tr>
					<?php foreach ( $row as $val): ?>
					<td>
						<?=$val?>
					</td>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
			<?php } ?>
		</tbody>
	<?php } ?>
</table>