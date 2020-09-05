<template>
  <main class="search-wrapper">
    <template v-if="post.length > 0">
      <div class="main-grid">
        <div class="search-results-header-wrapper">
          <h2 class="search-results-header">
            Нашлось {{ resultsCount }}
          </h2>
        </div>
        <NewsItem v-for="post in posts" :key="post.ID" :post="post" />
      </div>
      <LoadMore count="10" total="allCount" />
    </template>
    <template v-else>
      <div class="main-grid">
        <div class="search-results-header-wrapper">
          <h2 class="search-results-header">
            Поиск не дал результатов
          </h2>
        </div>
      </div>
    </template>
  </main>
</template>

<script>
import urls from '@/assets/js/urls'
import NewsItem from '@/components/NewsItem'
import LoadMore from '@/components/LoadMore'

export default {
  name: 'SearchPage',
  transition: 'fade',
  components: {
    NewsItem,
    LoadMore
  },
  async asyncData ({ $axios, route }) {
  },
  data () {
    return {
      isLoading: false,
      page: 1,
      posts: [],
      isNeedToUpload: false,
      resultsCount: '',
      allCount: 0
    }
  },
  computed: {
    searchString () {
      return this.$route.fullPath
    }
  },
  mounted () {
    this.$root.$on('goSearch', (restString) => { this.searchRequest(restString) })
  },
  methods: {
    infiniteHandler ($state) {
      if (this.isLoading) { return }
      this.isLoading = true
      const request = {
        endpoint: `${urls.restURL}${this.searchString}&page=${this.page}`,
        headers: urls.restHeaders
      }
      this.$axios.get(request.endpoint)
        .then((res) => {
          if (res.data.posts.length > 0) {
            this.page += 1
            this.posts.push(...res.data.posts)
            this.isNeedToUpload = res.data.allCount > res.data.posts.length
            this.resultsCount = res.data.resultsCount
            this.isLoading = false
            $state.loaded()
          } else {
            this.isLoading = true
            $state.complete()
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async searchRequest (restString) {
      if (restString === '' || restString === '/s?') {
        this.isNeedToUpload = false
        this.resultsCount = ''
        this.posts = []
        this.isLoading = false
        if (this.$route.path !== '/search') { this.$router.replace({ path: '/search' }) }
        return
      }
      this.page = 1
      if (this.isLoading === true) { return }
      this.isLoading = true
      const request = {
        endpoint: `${urls.restURL}/search${restString}&page=${this.page}`,
        headers: urls.restHeaders
      }
      try {
        const res = await this.$axios.get(request.endpoint)
        if (res.data.posts.length > 0) {
          this.posts = res.data.posts
          this.isNeedToUpload = res.data.allCount > res.data.posts.length
          this.resultsCount = res.data.resultsCount
          this.page += 1
          this.isLoading = false
          if (this.$route.path !== '/search' + restString) { this.$router.replace({ path: '/search' + restString }) }
        } else {
          this.posts = false
          this.isNeedToUpload = false
          this.resultsCount = ''
          this.isLoading = false
          if (this.$route.path !== '/search' + restString) { this.$router.replace({ path: '/search' + restString }) }
        }
        this.isLoading = false
      } catch (error) {
        console.log(error)
      }
    }
  }
}
</script>
</template>
