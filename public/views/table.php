<?php

if ( ! isset( $repositories ) ) {
	$repositories = array();
}

?>

<table class="gitrepos-table">
	<tbody>
	<?php foreach ( $repositories as $repository ) : ?>
		<tr>
			<td>
				<div>
					<p class="gitrepos-name">
						<a href="<?php echo $repository['url'] ?>" target="_blank">
						<?php echo $repository['name']; ?>
						</a>
					</p>
					<div class="gitrepos-counters">
						<?php foreach ( $repository['counters'] as $type => $count ) : ?>
						<div class="gitrepos-count" title="<?php echo $count . ' ' . $type; ?>">
							<span class="gitrepos-count-value" aria-label="<?php echo $count . ' ' . $type; ?>">
								<?php echo $count; ?>
							</span>
							<?php echo gitrepos_get_icon( $type ); ?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</td>
			<td>
				<div class="gitrepos-data">
					<p class="gitrepos-description">
						<?php echo $repository['description'] ?? '' ?>
					</p>
					<div class="gitrepos-topics">
						<?php foreach ( $repository['topics'] as $topic ) : ?>
							<span class="gitrepos-topic"><?php echo $topic ?></span>
						<?php endforeach; ?>
					</div>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
