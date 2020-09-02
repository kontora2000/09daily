    <main>
      <div class="article-body-cont">
        <?php if ($post['thumb'] !== false) : ?>
          <div class="article-image-cover-cont">
            <img class="article-image-cover" src="<?php echo $post['thumb']; ?>" />
          </div>
        <?php endif; ?>
        <div class="article-item-header-card rubric-<?php echo $post['category_id']; ?>">
          <div class="article-item-rubrics-cont">
            <a class="article-item-rubric-link link-underline" href="<?php echo $post['category_link']; ?>">
              <?php echo $post['category']; ?>
            </a>
          </div>
          <div class="article-item-page-header-cont">
            <h1 class="article-item-page-header"><?php echo $post['post_title']; ?></h1>
            <span class="article-item-page-subheader"><?php echo $post['subheader']; ?></span>
          </div>
          <div class="article-item-page-meta-cont">
            <div class="publication-date">
              <nobr class="publication-time">
                <?php echo $post['time']; ?></nobr>, <?php echo $post['day']; ?>&nbsp;<?php echo $post['month']; ?>&nbsp;<?php echo $post['year']; ?>
            </div>
            <?php if ($post['views'] !== false) : ?>
              <div class="article-item-page-views-counter">
                <?php echo $post['views']; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php if ($post['subtitle'] !== '') : ?>
          <div class="article-item-subtitle">
            <?php echo $post['subtitle']; ?>
          </div>
        <?php endif; ?>
        <div class="article-item-text-wrapper">
          <?php echo $post['post_content']; ?>
        </div>
        <?php if ($post['author']!==false):?>
          <div class="article-author"><?php echo $post['author']; ?></div>
        <?php endif;?>
        <?php if ($post['tags'] !== false): ?>
          <div class="article-item-page-tags-cont">
            <?php foreach ($post['tags'] as $tag) : ?>
              <a class="tag" href="<?php echo $tag->url; ?>">
                <?php echo $tag->name; ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </main>
   