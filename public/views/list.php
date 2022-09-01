<?php

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
				<p class="gitrepos-description">
					<?php echo $repository['description'] ?? '' ?>
				</p>
			</div>
			<div class="gitrepos-single-repo--right">
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
				<div class="gitrepos-topics">
					<?php foreach ( $repository['topics'] as $topic ) : ?>
						<span class="gitrepos-topic"><?php echo $topic ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
