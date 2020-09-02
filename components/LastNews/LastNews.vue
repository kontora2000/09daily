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
          <span class="link-to-news-gradient"></span>
        </span>
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
