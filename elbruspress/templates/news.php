<main>
  <div class="news-body-cont">
    <div class="news-item-page-header-cont">
      <h1 class="news-item-page-header"><?php echo $post['post_title'];?></h1>
    </div>
    <div class="news-item-page-meta-cont">
      <div class="publication-date">
        <nobr class="publication-time"><?php echo $post['time'];?></nobr>, <?php echo $post['day'];?>&nbsp;<?php echo $post['month'];?>&nbsp;<?php echo $post['year'];?>
      </div>
      <?php if ($post['author']!==false):?>
      <div class="news-item-author-source-cont">
        <a class="news-item-author-source-cont-link link-underline" href="#"><?php echo $post['author'];?></a>
      </div>
      <?php endif;?>
      <div class="news-item-rubrics-cont">
        <a class="news-item-rubric-link link-underline rubric-1" href="#"><?php echo $post['category'];?></a>
      </div>
      <div class="news-item-page-views-counter"><?php echo $post['views'];?></div>
    </div>
    <div class="news-item-text-wrapper">
      <?php if ($post['thumb'] !== false):?>
        <div class="news-item-pic-wrapper">
          <img class="news-item-pic" src="<?php echo $post['thumb'];?>" />
          <div class="news-item-pic-comment-wrapper">
            <div class="news-item-pic-copyright"><?php echo $post['thumb_caption'];?></div>
          </div>
        </div>
      <?php endif;?>
    <?php echo $post['post_content'];?>
    </div>
    <?php
      if ($post['tags'] !== false):?>
      <div class="news-item-page-tags-cont">
        <?php foreach ($post['tags'] as $tag):?>
            <a class="tag" href="<?php echo $tag->url;?>"><?php echo $tag->name;?></a>
        <?php endforeach;?>
      <?php endif;?>
    </div>
  </div>
  <div class="last-news-grid">
    <h2 class="last-news-header">Последнее</h2>
    <div class="ad-item-wrapper last-news-ad-grid-1">
      <div class="ad-item">
        <a class="ad-item-link" href="#"><img class="ad-item-img" src="<?php echo get_template_directory_uri();?>/assets/images/ad-banner-350x500-1.png" /></a>
        <a class="link-to-ad-prices link-underline" href="#">Разместить рекламу</a>
      </div>
    </div>
    <div class="news-item-wrapper">
      <a class="news-item" href="#">
        <div class="news-item-ill-cont">
          <div class="item-ill-gradient-wrapper">
            <div class="item-ill-gradient"></div>
            <img class="news-item-ill" src="<?php echo get_template_directory_uri();?>/assets/images/news-ill-1.png" />
          </div>
        </div>
        <div class="news-item-info-wrapper">
          <div class="rubric-title-wrapper">
            <span class="rubric-title">Новости</span>
          </div>
          <div class="news-item-header-and-date-wrapper">
            <div class="news-item-header-cont">
              <span class="news-item-header">Заголовок новости</span>
              <span class="news-item-subheader">Подзаголовок-подзаголовок</span>
            </div>
            <div class="publication-date">Час назад</div>
          </div>
        </div>
      </a>
    </div>
    <div class="news-item-wrapper">
      <a class="news-item" href="#">
        <div class="news-item-info-wrapper">
          <div class="rubric-title-wrapper">
            <span class="rubric-title">Новости</span>
          </div>
          <div class="news-item-header-and-date-wrapper">
            <div class="news-item-header-cont">
              <span class="news-item-header">Заголовок новости</span>
              <span class="news-item-subheader">Подзаголовок-подзаголовок</span>
            </div>
            <div class="publication-date">2 часа назад</div>
          </div>
        </div>
      </a>
    </div>
    <div class="news-item-wrapper">
      <a class="news-item" href="#">
        <div class="news-item-info-wrapper">
          <div class="rubric-title-wrapper">
            <span class="rubric-title">Новости</span>
          </div>
          <div class="news-item-header-and-date-wrapper">
            <div class="news-item-header-cont">
              <span class="news-item-header">Заголовок новости</span>
              <span class="news-item-subheader">Подзаголовок-подзаголовок</span>
            </div>
            <div class="publication-date">3 часа назад</div>
          </div>
        </div>
      </a>
    </div>
    <div class="article-item-wrapper">
      <a class="article-item rubric-5">
        <div class="article-item-ill-cont">
          <div class="item-ill-gradient-wrapper">
            <div class="item-ill-gradient"></div>
            <img class="article-item-ill" src="<?php echo get_template_directory_uri();?>/assets/images/article-ill-1.png" />
          </div>
        </div>
        <div class="article-item-info-wrapper">
          <div class="rubric-title-wrapper">
            <span class="rubric-title">Аналитика</span>
          </div>
          <div class="article-item-header-and-date-wrapper">
            <div class="article-item-header-cont">
              <span class="article-item-header">Заголовок статьи</span>
              <span class="article-item-subheader">Подзаголовок-подзаголовок</span>
            </div>
            <div class="publication-date">4 часа назад</div>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="button-showmore-wrapper">
    <button class="big-button button-showmore">Показать ещё</button>
  </div>
</main>