<template>
  <div class="last-news-cont">
    <div class="cont-header-rubric cont-header">
      <nuxt-link class="cont-header-rubric-link" to="/news">
        Последние новости
      </nuxt-link>
    </div>
    <div class="last-news-wrapper">
      <Item v-for="(mypost, index) in posts" :key="mypost.ID" :post="mypost" :number="index+1" />
    </div>
    <div class="link-to-news-cont">
      <nuxt-link class="link-to-news" to="/news">
        <span class="link-to-news-letters">Все&nbsp;новости</span>
        <span class="link-to-news-arrow-gradient">
          <span class="link-to-news-arrow">→</span>
<<<<<<< HEAD
=======
          <span class="link-to-news-gradient">
            <div class="round round-1 scale-in"></div>
            <div class="round round-2 scale-in"></div>
            <div class="round round-3 scale-in"></div>
            <div class="round round-4 scale-in"></div>
            <div class="round round-5 scale-in"></div>
            <div class="round round-6 scale-in"></div>
          </span>
>>>>>>> 249ef0c5e1f4e86837923e4e35ddf2939ae049a0
        </span>
        <div class="link-to-news-gradient">
          <div class="last-news-round round-1 scale-in-fast-lastnews" />
          <div class="last-news-round round-2 scale-in-fast-lastnews" />
          <div class="last-news-round round-3 scale-in-fast-lastnews" />
          <div class="last-news-round round-4 scale-in-fast-lastnews" />
          <div class="last-news-round round-5 scale-in-fast-lastnews" />
        </div>
      </nuxt-link>
    </div>
  </div>
</template>

<script>
import urls from '@/assets/js/urls.js'
import Item from '@/components/LastNews/Item.vue'

export default {
  name: 'LastNews',
  components: {
    Item
  },
  async fetch () {
    const request = {
      endpoint: `${urls.restURL}/last/1`,
      headers: {
        ContentType: 'application/json',
        Accept: 'application/json'
      }
    }
    let res
    try {
      res = await this.$axios.get(request.endpoint, request.headers)
    } catch (e) {
      console.log(e)
    }
    this.posts = res.data.posts
  },
  data () {
    return {
      posts: []
    }
  }
}
</script>

<style scoped>
  .last-news-round  {
    position: absolute;
    border-radius:50%;
    background:rgba(0, 85, 255, 1);
    z-index:1;
    padding:1.5rem;
  }

  .link-to-news-gradient {
    position: relative;
    top: -3.2rem;
    left: 80%;
    z-index: -1;
  }
</style>
