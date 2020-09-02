<?php
class elbrus_model
{
  function __construct()
  {
    include_once('utils.php');
    $this->utils =  new elbrus_utils();
  }

  public $utils;



  /**Посты */

  /**
   * Получает посты для главной страницы
   */
  public function get_mainpage_posts($page = 1, $count = 20, $exclude_attached = true)
  {
    $meta_query = array();
    if ($exclude_attached === true) {

    }
      // $meta_query = array(
      //   'relation' => 'OR',
      //   [
      //     'key' => 'attached',
      //     'value' => '0',
      //     'compare' => '=='
      //   ],
      //   [
      //     'key' => 'attached',
      //     'value' => '',
      //     'compare' => '=='
      //   ]
      // );
    $args = array(
      'paged' => $page,
      'post_status' => 'publish',
      'post_type' => 'post',
      'posts_per_page' => $count,
      // 'offset' => ($page === 1) ? 0 : (10*$page)
    );
    // if (!empty($meta_query)) {
    //   $args['meta_query'] = $meta_query;
    // }
    if ($exclude_attached === true) {
      $args['post__not_in']  = get_option( 'sticky_posts' );
    }
    $query = new WP_Query($args);
    $posts = $query->posts;
    $full_posts = array();
    $full_posts['allCount'] = $query->found_posts;
    $full_posts['postCount'] = $query->post_count;
    $full_posts['posts'] = $this->to_fullpost_array($posts);
    return $full_posts;
  }


  public function get_attached_posts($count = 4)
  {
    $meta_query = array(
      'relation' => 'OR',
      [
        'key' => 'attached',
        'value' => '1',
        'compare' => '=='
      ]
    );
    $args = array(
      'paged' => 1,
      'posts_per_page' => 4, 
      'post__in'  => get_option( 'sticky_posts' )
    );
    // $args = array(
    //   'paged' => 1,
    //   'post_status' => 'publish',
    //   'post_type' => 'post',
    //   'posts_per_page' => $count,
    //   'meta_query' => $meta_query
    // );
    $posts = get_posts($args);
    $full_posts['posts'] = $this->to_fullpost_array($posts);
    return $full_posts;
  }



  /**
   * Получает посты для категории
   */
  public function get_category_posts($page = 1, $count = 20, $slug = 'news')
  {
    $args = array(
      'paged' => $page,
      'order_by' => 'date',
      'category_name' => $slug,
      'post_status' => 'publish',
      'post_type' => 'post',
      'numberposts' => $count
    );
    $query = new WP_Query($args);
    $posts = $query->posts;
    $full_posts = array();
    $full_posts['allCount'] = $query->found_posts;
    $full_posts['postCount'] = $query->post_count;
    $full_posts['posts'] = $this->to_fullpost_array($posts);
    $full_posts['categoryDescr'] =  category_description( get_category_by_slug($slug)->term_id );
    return $full_posts;
  }


  /**
   * Получаем посты по строке
   */
  public function get_posts_by_search_string($s = '', $page = 1, $count = 10, $tags = [], $authors = [])
  {
    if ($s === '' && empty($tags) && empty($authors))
      return false;
    $args = array(
      'order_by' => 'date',
      'post_status' => 'publish',
      'post_type' => 'post',
      'paged' => $page,
      'numberposts' => $count
    );
    //string
    if (trim($s) !== '') {
      $args['s'] =  sanitize_text_field($s);
    }
    //tags
    $tags_id = array();
    if (is_array($tags) && !empty($tags)) {
      $tags_id = array();
      foreach ($tags as $key => $tag) {
        $tag = str_replace('_', ' ', $tag);
        $term = get_term_by('name', $tag, 'post_tag');
        if ($term !== false)
          $tags_id[$key] = $term->term_id;
      }
    }
    if (!empty($tags_id))
      $args['tag__and'] = $tags_id;

    //authors
    if (!empty($authors)) {
    }

    $meta_query = array();
    foreach ($authors as $author) {
      $author = str_replace('_', ' ', $author);
      $author_term = get_term_by('name', $author, 'authors');
      if ($author_term !== false)
        $meta_query[] = array('key' => 'post_author', 'value' => $author_term->term_id, 'compare' => 'LIKE');
    }
    if (!empty($meta_query)) {
      $args['meta_query'] = $meta_query;
    }
    $query = new WP_Query($args);
    $posts = $query->posts;
    $full_posts = array();
    $full_posts['allCount'] = $query->found_posts;
    $full_posts['postCount'] = $query->post_count;
    $full_posts['posts'] = $this->to_fullpost_array($posts);
    $full_posts['resultsCount'] = $this->utils->rus_search_post_count($query->found_posts);
    return $full_posts;
  }


  /**преобразует массив постов WP_POST в массив полных данных о посте*/
  public function to_fullpost_array($posts)
  {
    $full_posts = array();
    foreach ($posts as $post) {
      $date_diff = $this->utils->day_diff_from_today(strtotime($post->post_date));
      $date = '123';
      if ($date_diff === 0) {
        $date = human_time_diff(get_the_time('U', $post->ID), current_time('timestamp')) . ' назад';
      }
      if ($date_diff === 1) {
        $date = 'Вчера в ' . get_the_date('H:i', $post->ID);
      }
      if ($date_diff > 1) {
        $date = get_the_date('j F в H:i', $post->ID);
      }
      $categories = get_the_category($post->ID);
      if (!empty($categories)) {
        $category = $categories[0];
      } else {
        $category = get_category(1);
      }
      $full_posts[] = array(
        'title' => $post->post_title,
        'date' => $date,
        'post_date' => $date,
        'thumb' => get_the_post_thumbnail_url($post->ID),
        'views' => $this->utils->rus_views(get_field('views', $post->ID)),
        'permalink' => get_the_permalink($post->ID),
        'category' => $category->name,
        'category_link' => $category->slug,
        'category_id' => $category->cat_ID,
        'subtitle' => '',
        'subheader' => get_field('subheader', $post->ID),
        'attached' => get_field('attached', $post->ID),
        'id' => $post->ID,
        'slug' => $post->post_name,
        'link' => '/' . $category->slug . '/' . $post->post_name
      );
    }
    return $full_posts;
  }



  /**
   * Получает пост для страницы одной новости
   */
  public function get_post($post_ID = null)
  {
    $post = false;
    if ($post_ID === null || !is_numeric($post_ID) || $post_ID < 0)
      $post = get_post(null, ARRAY_A);
    $post = get_post($post_ID, ARRAY_A);
    $categories = get_the_category($post['ID']);
    $category = false;
    if (!empty($categories)) {
      $category = $categories[0];
    } else {
      $category = get_category(1);
    }
    $post['category'] = $category->name;
    $post['category_id'] = $category->cat_ID;
    $post['category_link'] = $category->slug;

    $date_diff = $this->utils->day_diff_from_today(strtotime($post['post_date']));
    $post['day'] = get_the_date('j', $post['ID']);
    $post['year'] = get_the_date('Y', $post['ID']);
    $post['month'] = $this->utils->num_to_rus_month(get_the_date('m', $post['ID']));
    $post['time'] = get_the_date('H:i', $post['ID']);
    $post['date_diff'] = $date_diff;
    $post['thumb'] = get_the_post_thumbnail_url($post['ID']);
    $post['thumb_caption'] = get_the_post_thumbnail_caption($post['ID']);
    $post['views'] = $this->get_post_views($post['ID']);
    $post['permalink'] = get_the_permalink($post['ID']);

    $post['subtitle'] = '';
    $post['tags'] = $this->get_post_tags($post['ID']);
    $post['author'] = $this->get_post_author($post['ID']);
    $post['post_content'] = apply_filters('the_content', $post['post_content']);
    $post['subheader'] = get_field('subheader', $post['ID']);
    $post['subtitle'] = get_field('subtitle', $post['ID']);

    $post['post_content'] = $this->utils->remove_subheader($post['post_content']);
    $post['post_content'] = $this->utils->remove_subtitle($post['post_content']);

    if ($post['category_link'] === 'news') {
      $post['post_content'] = $this->utils->news_p_class($post['post_content']);
    } else {
      $post['post_content'] = $this->utils->article_p_class($post['post_content']);
    }
    return $post;
  }

  public function get_postID_by_slug($post_slug)
  {
    $args = array(
      'name'        => $post_slug,
      'post_type'   => 'post',
      'post_status' => 'publish',
      'numberposts' => 1
    );
    $posts = get_posts($args);
    if ($posts) {
      return $posts[0]->ID;
    } else return false;
  }

  public function get_post_by_slug($post_slug)
  {
    $post_ID = (int) $this->get_postID_by_slug($post_slug);
    $post = $this->get_post($post_ID);
    return $post;
  }


  public function get_post_tags($post_ID)
  {
    $tags = wp_get_post_tags($post_ID);
    if (is_wp_error($tags) === true)
      return false;
    else return $tags;
  }

  public function get_post_views($post_ID)
  {
    $views = (int) get_field('views', $post_ID);
    if ($views) {
      return $this->utils->rus_views($views);
    } else return false;
  }

  public function get_post_author($post_ID)
  {
    $author_term = get_field('post_author', $post_ID);
    if ($author_term) {
      return $author_term->name;
    } else
      return false;
  }



  /**ХЕДЕР */

  /**
   * Получает информацию для open-graph 
   */
  public function get_og_info()
  {
    if (is_single()) {
      $og_info['descr'] = wp_strip_all_tags(get_the_excerpt());
      $og_info['title'] = get_the_title();
      $og_info['url'] = get_the_permalink();
      $og_info['site'] = home_url();
      $og_info['image'] = get_the_post_thumbnail_url();
      return $og_info;
    }
    if (is_home()) {
      $og_info['descr'] = get_bloginfo('description');
      $og_info['title'] = get_bloginfo('name');
      $og_info['url'] = get_bloginfo('url');
      $og_info['site'] = get_bloginfo('url');
      //$og_info['image'] = WP_Theme::get_screenshot();
    }
    if (is_category()) {
      $og_info['descr'] = 'ЭльбрусПресс - страница рубрики';
      $og_info['title'] = wp_title();
      $og_info['url'] = get_the_permalink();
      $og_info['site'] = home_url();
    }
    return false;
  }

  public function get_nav_menu()
  {
    $menu =  wp_get_nav_menu_items('Главное меню', [
      'output_key'  => 'menu_order',
    ]);
    if ($menu !== false) {
      $replaceURL = home_url('/category/');
      foreach ($menu as $menu_item) {
        $menu_item->url = str_replace($replaceURL, '', $menu_item->url);
      }
    }
    return $menu;
  }

  /**ПОИСК */

  /**РЕКЛАМА */
  public function get_all_adv()
  {
    $args = array(
      'post_type' => 'denrespadv'
    );
    $posts =  get_posts($args);
    foreach ($posts as $post) {
      $advs[] = array(
        'img' => get_the_post_thumbnail_url($post->ID),
        'url' => $post->post_excerpt
      );
    }
  }

  public function get_adv_by_type($type)
  {

    $args = array(
      'post_type' => 'denrespadv',
      's' => $type,
      'exact' => true,
      'sentence' => true
    );
    $posts =  get_posts($args);
    $advs = array();
    foreach ($posts as $post) {
      $advs[] = array(
        'img' => get_the_post_thumbnail_url($post->ID),
        'url' => $post->post_excerpt
      );
    }
    return $advs;
  }
}
