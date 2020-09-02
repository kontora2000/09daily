<template>
  <div :class="'ad-category-'+ number + '-cont'">
    <div :class="'ad-category-'+ number +'-wrapper'">
      <nuxt-link class="ad-category-link" to="/adv">
        <img class="ad-category-img ad-img" src="img/ad/mainpage-1.png">
      </nuxt-link>
      <div class="ad-prices-link-wrapper">
        <nuxt-link class="ad-prices-link link-underline" to="/adv">
          Разместить рекламу
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdvCat',
  props: {
    number: {
      type: Number,
      default: 1
    }
  }
}
</script>
