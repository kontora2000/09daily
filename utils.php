<?php


class elbrus_utils {

  function __construct(){
    date_default_timezone_set('Europe/Moscow');
  }
    
  private $rus_month = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
  private $rus_month_dir = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
  private $rus_weekdays = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
  
  /*
  Пребразует номер месяца в его русское название со склонением
  */
  public function num_to_rus_month($num)
  {
    $num = (int)$num;
    if ($num < 1 || $num > 12)
    $num = 1;
    return $this->rus_month[$num - 1];
  }
  
  /*
  Пребразует номер месяца в его русское название БЕЗ СКЛОНЕНИЯ 
  */
  public function num_to_rus_month_dir($num)
  {
    if ($num < 1 || $num > 12)
    $num = 1;
    return $this->rus_month_dir[$num - 1];
  }
  
  /*
  Пребразует номер дня недели в его русское название 
  */
  public function num_to_rus_weekday($num)
  {
    if ($num < 1 || $num > 7)
    $num = 1;
    return $this->rus_weekdays[$num - 1];
  }
  
  
  /*
  Склоняет просмотры 
  */
  public function rus_views($num)
  {
    $rem = $num;
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
      return $num.' просмотров';
    if ($num_x > 1 && $num_x < 5)
      return $num.' просмотра';
    if ($num_x == 1)
      return $rem. ' просмотр';
    return $rem.' просмотров'; 
  }

  public function rus_search_post_count($num)
  {
    $rem = $num;
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
      return 'Найдено'. $rem.' постов';
    if ($num_x > 1 && $num_x < 5)
      return  'Найдено '. $rem.' поста';
    if ($num_x == 1)
      return 'Найден '.$rem. ' пост';
    return 'Найдено '.$rem.' постов'; 
  }
  
  /**
  * Склоняет и выводит слово в взависимости от количества 
  * @param int $num количество 
  * @param string one слово для 1, например, "комментарий"
  * @param string two_four слово для 2-4, например, "комментария"
  * @param string more слово для 5 и больше, например, "комментариев"
  */
  public function rus_numerics($num, $one, $two_four, $more)
  {
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
      return $more;
    if ($num_x > 1 && $num_x < 5)
      return $two_four;
    if ($num_x == 1)
      return $one;
    return $more;
  }
  
  
  /**
  *Считает разницу в днях недели между сеголняшним днем и датой поста
  *@return 0 - если пост опубликован сегодня, 1 - если пост опубликован вчера, 2 - если пост опубликован более одного дня назад
  */
  public function day_diff_from_today($date = null)
  {
    $day = 0;
    $today_day = current_time('j');
    $today_month = current_time('n');
    $post_date = array();
    if ($date != null) {
      $post_date = explode(' ', date('j n t', $date));
    } else {
      $post_date = explode(' ', get_the_time('j n t'));
    }
    $post_day = $post_date[0];
    $post_month = $post_date[1];
    $post_month_max_days = $post_date[2];
    if ($post_month == $today_month) {
      $day = $today_day - $post_day;
      if ($day > 2)
        $day = 2;
      return $day;
    }
    if ($today_month > $post_month) {
      $day = 2;
      if ($post_month_max_days == 30 && $today_day == 1)
        $day = 1;
      if ($post_month_max_days == 31 && $today_day == 1)
        $day = 1;
      if ($post_month_max_days == 28 && $today_day == 1)
        $day = 1;
      return $day;
    } else
    $day = 2;
    return $day;
  }

  public function news_p_class($content) {
    return preg_replace('/<p([^>]+)?>/', '<p$1 class="news-item-p">', $content);
  }

  public function article_p_class($content) {
    return preg_replace('/<p([^>]+)?>/', '<p$1 class="article-item-p">', $content);
  }

  public function extract_subheader($content) {
    if ($content === '')
      return false;
    $match = array();
    preg_match('/<div class="subheader">(.*?)<\/div>/s', $content, $match);
    if (!empty($match)) {
      $match[0] = str_replace('<div class="subheader">', '', $match[0]);
      $match[0] = str_replace('</div>', '', $match[0]);
      return $match[0];

    }
    else return false;
  }

  public function remove_subheader($content) {
     return preg_replace('/<div class="subheader">(.*?)<\/div>/s', '', $content);
  }

  public function remove_subtitle($content) {
    return preg_replace('/<div class="wp-block-lazyblock-subtitle">(.*?)<\/div>/s', '', $content);
 }



  public function news_image($content) {
    return preg_replace('/"article-item-pic/', '"news-item-pic', $content);
  }

}
