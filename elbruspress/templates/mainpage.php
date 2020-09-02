
<main>
  <div class="mainpage-grid">
    <div class="clear-item-cont on-desktop-and-tablet"></div>
    <div class="attached-news-cont">
      <ul class="attached-news-list">
        <?php $k = 0;
        foreach ($attached_posts as $post) : $k++;
          if ($k > 1) : ?>
            <li class="attached-news-list-item-link-cont active">
              <a class="attached-news-list-item-link" href="<?php echo $post['permalink']; ?>">
                <span class="news-item-header"><?php echo $post['title']; ?></span>
                <span class="news-item-subheader"><?php echo $post['subtitle']; ?></span>
              </a>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
      <?php $post = $attached_posts[0]; ?>
      <div class="attached-news-item-1">
        <a href="<?php echo $post['permalink']; ?>">
          <div class="attached-news-item-info-wraper">
            <div class="rubric-title-wrapper">
              <span class="rubric-title"><?php echo $post['category']; ?></span>
            </div>
            <div class="attached-news-item-header-and-date-wrapper">
              <div class="news-item-header-cont">
                <span class="news-item-header"><?php echo $post['title']; ?></span>
                <span class="news-item-subheader"><?php echo $post['subtitle']; ?></span>
              </div>
              <div class="publication-date"><?php echo $post['date']; ?></div>
            </div>
          </div>
          <div class="attached-news-item-bg-container">
            <?php if ($post['thumb'] !== false) : ?>
              <div class="attached-news-item-img-cont"><img src="<?php echo $post['thumb']; ?>" /></div>
            <?php endif; ?>
            <div class="attached-news-item-gradient-cont"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="social-item-wrapper telegram-item-wrapper">
      <a class="social-item telegram-item" href="#">
        <div class="telegram-item-bg"></div>
        <div class="telegram-item-logo"></div>
        <div class="social-item-account"></div>
        <div class="social-item-title">Наш канал<br>в&nbsp;<i>Телеграме</i></div>
      </a>
    </div>
    <div class="social-item-wrapper twitter-item-wrapper">
      <a class="social-item twitter-item" href="#">
        <div class="twitter-item-bg"></div>
        <div class="twitter-item-logo"></div>
        <div class="social-item-account"></div>
        <div class="social-item-title">Мы&nbsp;в<br><i>Твиттере</i></div>
      </a>
    </div>
    <div class="ad-item-wrapper mainpage-ad-grid-1">
      <div class="ad-item">
        <a class="ad-item-link" href="#"><img class="ad-item-img" src="<?php echo $images_path;?>ad-banner-350x500-1.png" /></a>
        <a class="link-to-ad-prices link-underline" href="#">Разместить рекламу</a>
      </div>
    </div>
    <div class="ad-item-wrapper mainpage-ad-grid-2">
      <div class="ad-item">
        <a class="ad-item-link" href="#"><img class="ad-item-img" src="<?php echo $images_path;?>ad-banner-350x500-2.png" /></a>
        <a class="link-to-ad-prices link-underline" href="#">Разместить рекламу</a>
      </div>
    </div>
    <?php foreach ($posts['posts'] as $post) :
      if ($post['category_id'] === 1) : ?>
        <div class="news-item-wrapper">
          <a class="news-item" href="<?php echo $post['permalink']; ?>">
            <?php if ($post['thumb'] !== false) : ?>
              <div class="news-item-ill-cont">
                <div class="item-ill-gradient-wrapper">
                  <div class="item-ill-gradient"></div>
                  <img class="news-item-ill" src="<?php echo $post['thumb']; ?>">
                </div>
              </div>
            <?php endif; ?>
            <div class="news-item-info-wrapper">
              <div class="rubric-title-wrapper">
                <span class="rubric-title"><?php echo $post['category']; ?></span>
              </div>
              <div class="news-item-header-and-date-wrapper">
                <div class="news-item-header-cont">
                  <span class="news-item-header"><?php echo $post['title']; ?></span>
                  <span class="news-item-subheader"><?php echo $post['subtitle']; ?></span>
                </div>
                <div class="publication-date"><?php echo $post['date']; ?></div>
              </div>
            </div>
          </a>
        </div>
      <?php else : ?>
        <div class="article-item-wrapper">
          <a class="article-item rubric-<?php echo $post['category_id']; ?>" href="<?php echo $post['permalink']; ?>">
            <?php if ($post['thumb'] !== false) : ?>
              <div class="article-item-ill-cont">
                <div class="item-ill-gradient-wrapper">
                  <div class="item-ill-gradient"></div>
                  <img class="article-item-ill" src="<?php echo $post['thumb']; ?>" />
                </div>
              </div>
            <?php endif; ?>
            <div class="article-item-info-wrapper">
              <div class="rubric-title-wrapper">
                <span class="rubric-title"><?php echo $post['category']; ?></span>
              </div>
              <div class="article-item-header-and-date-wrapper">
                <div class="article-item-header-cont">
                  <span class="article-item-header"><?php echo $post['title']; ?></span>
                  <span class="article-item-subheader"><?php echo $post['subtitle']; ?></span>
                </div>
                <div class="publication-date"><?php echo $post['date']; ?></div>
              </div>
            </div>
          </a>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <div class="button-showmore-wrapper">
    <button class="big-button button-showmore">Показать ещё</button>
  </div>
</main>