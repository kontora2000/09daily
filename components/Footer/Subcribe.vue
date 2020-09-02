<template>
  <div class="subsrcibe-cont-footer">
    <div class="cont-header">Подписка <br class="only-desktop" />на&nbsp;рассылку</div>
    <div class="subsribe-input-cont">
      <div class="subscribe-input-wrapper input-wrapper">
        <button class="button-subscribe-send"><span class="button-subscribe-send-sign only-desktop">Подписаться</span><span class="icon-send"><svg class="icon-svg icon-send-svg"><use xlink:href="sprite.svg#icon-send"></use></svg></span></button>
        <input type="text" required />
        <label data-placeholder="Ваш имейл" class="floating-label"></label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name:'SubscibeForm'
}
</script>
