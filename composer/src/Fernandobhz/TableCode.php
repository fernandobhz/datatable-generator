<table
	<?=$attributes?>
	class="<?="$verb-$cssclass $classes"?> dtgen table table-striped table-bordered"
	data-name="<?=$name?>" 
	data-action="<?=$action?>"
	>
	<?php if ( ! $opts['server-side'] ) { ?>
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
			<?php if ( ! $opts['server-side'] ) { ?>
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