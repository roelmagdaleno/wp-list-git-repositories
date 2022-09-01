<?php

use Roel\WP\GitRepos\Render;

if ( ! isset( $repositories ) ) {
	$repositories = array();
}

?>

<div class="gitrepos-list">
	<?php foreach ( $repositories as $repository ) : ?>
	<div class="gitrepos-single-repo">
		<div class="gitrepos-single-repo-container">
			<div class="gitrepos-single-repo--left">
				<p class="gitrepos-name">
					<a href="<?php echo $repository['url'] ?>" target="_blank">
						<?php echo $repository['name']; ?>
					</a>
				</p>
				<?php echo Render::description( $repository ); ?>
			</div>
			<div class="gitrepos-single-repo--right">
				<?php echo Render::counters( $repository ); ?>
				<?php echo Render::topics( $repository ); ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
