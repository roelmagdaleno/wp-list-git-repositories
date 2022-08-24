<?php

if ( ! isset( $repositories ) ) {
	$repositories = array();
}

$icons = array(
	'stargazers' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="gitrepos-count-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>',
	'forks'      => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="gitrepos-count-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" /></svg>',
);

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
							<?php echo $icons[ $type ]; ?>
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
