<template>
  <div class="main-grid last-posts-cont">
    <h1 class="last-posts-header">
      Последнее
    </h1>
    <Adv number="1" type="last" />
    <Item v-for="mypost in posts" :key="mypost.ID" :post="mypost" class="news-item-cont news-item" :number="1" />
  </div>
</template>

<script>
import Adv from '@/components/Adv.vue'
import urls from '@/assets/js/urls'
import Item from '@/components/LastNews/Item'

export default {
  name: 'LastNewsSingle',
  components: {
    Adv,
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
