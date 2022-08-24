<?php

if ( ! isset( $repositories ) ) {
	$repositories = array();
}

$icons = array(
	'stargazers' => '<svg xmlns="http://www.w3.org/2000/svg" class="gitrepos-count-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>',
	'forks'      => '<svg xmlns="http://www.w3.org/2000/svg" class="gitrepos-count-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>',
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
						<div class="gitrepos-count">
							<span class="gitrepos-count-value" aria-label="<?php echo $count . ' ' . $type ?>">
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
