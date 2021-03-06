<?php
/*
Template Name: Comic Storyline Archive
*/
get_header();
?>
<div <?php post_class(); ?>>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-head"></div><?php } ?>
	<div class="post-content">
		<div class="post-info">
			<div class="post-text">
				<h2 class="page-title"><?php the_title(); ?></h2>
			</div>
		</div>
		<ul id="storyline" class="level-0">
			<?php if (comicpress_themeinfo('enable-storyline-support') == 1) {
				if (($result = comicpress_themeinfo('storyline-category-order')) !== false) {
					$categories_by_id = comicpress_get_comic_category_objects_by_id();
					$current_depth = 0;
					$storyline_root = " class=\"storyline-root\"";
					foreach (explode(",", $result) as $node) {
						$parts = explode("/", $node);
						$target_depth = count($parts) - 2;
						$category_id = end($parts);
						$category = $categories_by_id[$category_id];
						$description = $category->description;
						$first_comic_in_category = comicpress_get_terminal_post_in_category($category_id);
						$first_comic_permalink = get_permalink($first_comic_in_category->ID);
						if ($target_depth < $current_depth) {
							echo str_repeat("</ul></li>", ($current_depth - $target_depth));
						}
						if ($target_depth > $current_depth) {
							for ($i = $current_depth; $i < $target_depth; ++$i) {
								$next_i = $i + 1;
								echo "<li><ul class=\"level-${next_i}\">";
							}
						} ?>
						
						<li id="storyline-<?php echo $category->category_nicename ?>"<?php echo $storyline_root; $storyline_root = null ?>>
							<a href="<?php echo get_category_link($category_id) ?>" class="storyline-title"><?php echo $category->cat_name ?></a>
							<div class="storyline-description">
								<?php if (!empty($description)) { ?>
									<?php echo $description ?>
								<?php } ?>
								<?php if (!empty($first_comic_in_category)) { ?>
									<?php _e('Begins with &ldquo;','comicpress'); ?><a href="<?php echo $first_comic_permalink ?>"><?php echo $first_comic_in_category->post_title ?></a><?php _e('&rdquo;','comicpress'); ?>
								<?php } ?>
							</div>
							<div class="storyline-foot"></div>
						</li>
						
						<?php $current_depth = $target_depth;
					}
					if ($current_depth > 0) {
						echo str_repeat("</ul></li>", $current_depth);
					}
				}
			} else { ?>
				<li><h3><?php _e('Storyline Support is not currently enabled on this site.','comicpress'); ?></h3><br /><br /><strong><?php _e('Note to the Administrator:','comicpress'); ?></strong><br /> <?php _e('To enable storyline support and manage storyline categories make sure you are running the latest version of the ','comicpress'); ?><a href="http://wordpress.org/extend/plugins/comicpress-manager/">ComicPress Manager</a> <?php _e('plugin and check your storyline settings from it\'s administration menu.','comicpress'); ?></h3></li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
	</div>
	<?php if (comicpress_themeinfo('enable_caps')) { ?><div class="post-foot"></div><?php } ?>
</div>

<?php get_footer() ?>