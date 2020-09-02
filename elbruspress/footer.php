<footer>
  <div class="footer-email-subscribe">
    <div class="footer-email-subscribe-header">
      <h3><i>Еженедельная</i></h3>
      <h4>Рассылка новостей</h4>
    </div>
    <form class="footer-email-subscribe-form">
      <div class="input-wrapper">
        <input type="email" class="subscribe-form-input" required />
        <label class="floating-label" data-placeholder="Ваш имейл"></label>
      </div>
      <input type="submit" class="subscribe-form-submit" value="Подписаться" />
    </form>
    <div class="footer-email-subscribe-note">Нажимая кнопку&nbsp;«Подписаться», вы&nbsp;соглашаетесь с&nbsp;<a class="link-underline" href="#">условиями обработки персональных данных</a></div>
  </div>
  <div class="footer-logo-cont">
    <a class="logo-link" href="/"><i>Эльбрус</i><span class="logo-triangle">▲</span>пресс</a>
  </div>
  <div class="footer-social-cont">
    <span class="footer-social-cont-title">В соцсетях</span>
    <a class="footer-social-link social-link social-link-telegram" href="#"><svg class="icon icon-social-telegram">
        <use xlink:href="<?php echo $svg_path;?>#icon-telegram"></use>
      </svg></a>
    <a class="footer-social-link social-link social-link-facebook" href="#"><svg class="icon icon-social-facebook">
        <use xlink:href="<?php echo $svg_path;?>#icon-facebook"></use>
      </svg></a>
    <a class="footer-social-link social-link social-link-vk" href="#"><svg class="icon icon-social-vk">
        <use xlink:href="<?php echo $svg_path;?>#icon-vk"></use>
      </svg></a><a class="footer-social-link social-link social-link-twitter" href="#">
      <svg class="icon icon-social-twitter">
        <use xlink:href="<?php echo $svg_path;?>#icon-twitter"></use>
      </svg></a>
  </div>
  <div class="footer-bottom-cont">
    <div class="copyright">©&thinsp;2020</div>
    <nav class="footer-rubrics-cont">
      <?php foreach ($nav_menu as $menu_item):?>
        <a class="rubric-link footer-rubric-link" href="<?php echo $menu_item->url;?>">
          <?php echo $menu_item->title;?>
        </a>
      <?php endforeach;?>
    </nav>
    <div class="by-kontora-cont">
      <a class="by-kontora-link" href="https://kontora.cc"></a>
    </div>
  </div>
  <div class="footer-bg-triangles">
    <svg class="footer-bg-triangle-left" width="991" height="679" viewBox="0 0 991 679" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path class="footer-bg-triangle-left-path" d="M495.799 3.29857e-06L991 679.163L0.597656 679.163L495.799 3.29857e-06Z" />
    </svg>
    <svg class="footer-bg-triangle-right" width="991" height="679" viewBox="0 0 991 679" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path class="footer-bg-triangle-right-path" d="M495.799 3.29857e-06L991 679.163L0.597656 679.163L495.799 3.29857e-06Z" />
    </svg>
  </div>
</footer>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" type="text/css">
<script src="/assets/js/chunk-vendors.21e83ae8.js"></script>
<script src="assets/js/app.13627dc4.js"></script>
</div><!--APP-->
</body>

</html>