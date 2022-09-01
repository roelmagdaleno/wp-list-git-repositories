<?php

use Roel\WP\GitRepos\Render;

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
					<?php echo Render::counters( $repository ); ?>
				</div>
			</td>
			<td>
				<div class="gitrepos-data">
					<?php echo Render::description( $repository ); ?>
					<?php echo Render::topics( $repository ); ?>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
