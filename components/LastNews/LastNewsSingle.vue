<template>
  <div class="main-grid last-posts-cont">
    <h1 class="last-posts-header">
      Последнее
    </h1>
    <Adv :number="1-0" type="last" />
    <NewsItem v-for="mypost in posts" :key="mypost.ID" :post="mypost" />
  </div>
</template>

<script>
import Adv from '@/components/Adv.vue'
import urls from '@/assets/js/urls'
import NewsItem from '@/components/NewsItem'

export default {
  name: 'LastNewsSingle',
  components: {
    Adv,
    NewsItem
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
    if (res.data.posts.length > 0) {
      this.posts = res.data.posts
      this.$root.$emit('lastmounted', res.data.allCount)
    }
  },
  data () {
    return {
      posts: [],
      page: 2
    }
  },
  mounted () {
    this.$root.$on('loadmore', this.upload)
  },
  methods: {
    upload () {
      this.$root.$emit('loadinglastsingle')
      window.setTimeout(async () => {
        const res = await this.$axios.get(`${urls.restURL}/last/${this.page}`)
        if (res.data) {
          if (res.data.posts.length > 0) {
            this.posts.push(...res.data.posts)
            this.$root.$emit('loadedlastsingle', true)
          } else {
            this.$root.$emit('loadedlastsingle', false)
          }
        }
      }, 1000)
    }
  }
}
</script>
