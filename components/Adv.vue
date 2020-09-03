<template>
  <div v-if="type === 'default'" :class="'ad-mainpage-'+ number + '-cont ad-wide'">
    <div :class="'ad-mainpage-'+ number +'-wrapper'">
      <a class="ad-mainpage-link" href="#">
        <img class="ad-mainpage-img-vertical ad-img" :src="'img/ad/mainpage-'+ number + '.png'">
      </a>
      <div class="ad-prices-link-wrapper">
        <nuxt-link class="ad-prices-link link-underline" to="/adv">
          Разместить рекламу
        </nuxt-link>
      </div>
    </div>
  </div>
  <div v-else class="ad-last-posts-1-cont">
    <div class="ad-last-posts-1-wrapper">
      <a class="ad-last-posts-link" href="#">
        <img class="ad-last-posts-img ad-img" src="/img/ad/mainpage-1.png">
      </a>
      <div class="ad-prices-link-wrapper">
        <a class="ad-prices-link link-underline" href="#">Разместить рекламу</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Adv',
  props: {
    number: {
      type: Number,
      default: 1
    },
    type: {
      type: String,
      default: 'default'
    }
  }
}
</script>
