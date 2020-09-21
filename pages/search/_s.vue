<template>
  <main class="search-wrapper">
    <template v-if="posts.length > 0">
      <div class="main-grid">
        <div class="search-results-header-wrapper">
          <h2 class="search-results-header">
            <span style="z-index:2">{{ resultsCount }}</span>
            <div class="search-results-round">
              <div class="search-round round-1 scale-in" />
              <div class="search-round round-2 scale-in" />
              <div class="search-round round-3 scale-in" />
              <div class="search-round round-4 scale-in" />
              <div class="search-round round-5 scale-in" />
              <div class="search-round round-6 scale-in" />
            </div>
          </h2>
        </div>
        <NewsItem v-for="post in posts" :key="post.ID" :post="post" />
      </div>
      <LoadMore :total="allCount" />
    </template>
    <template v-else-if="isNoResults">
      <div class="main-grid">
        <div class="search-results-header-wrapper">
          <h2 class="search-results-header">
            Поиск не дал результатов
          </h2>
        </div>
      </div>
    </template>
    <template v-else>
      <div class="main-grid">
        <div class="search-results-header-wrapper" />
      </div>
    </template>
  </main>
</template>

<script>
import urls from '@/assets/js/urls'
import NewsItem from '@/components/NewsItem'
import LoadMore from '@/components/LoadMore'

export default {
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
      allCount: 0,
      isNoResults: false
    }
  },
  computed: {
    searchString () {
      return this.$route.fullPath
    }
  },
  mounted () {
    this.$root.$on('goSearch', (restString) => {
      if (this.isLoading === false) {
        this.isLoading = true
        this.searchRequest(restString)
      }
    })
    if (this.$route.name === 'search-s') {
      if (this.$route.query.s !== '' && this.$route.query.s !== undefined) {
        this.$root.$emit('parseURL', this.$route.query.s)
      }
    }
  },
  methods: {
    infiniteHandler ($state) {
      if (this.isLoading) { return }
      if (this.isNeedToUpload === false) { return }
      this.isLoading = true
      const request = {
        endpoint: `${urls.restURL}/search${this.restString}&page=${this.page}`,
        headers: urls.restHeaders
      }
      this.$axios.get(request.endpoint)
        .then((res) => {
          if (res.data.posts.length > 0) {
            this.page += 1
            this.posts.push(...res.data.posts)
            this.isNeedToUpload = res.data.allCount > res.data.posts.length
            // this.resultsCount = res.data.resultsCount
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
        return
      }
      this.page = 1
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
        } else {
          this.posts = false
          this.isNeedToUpload = false
          this.resultsCount = ''
          this.isLoading = false
        }
        this.restString = restString
        this.isLoading = false
      } catch (error) {
        console.log(error)
      }
    }
  }
}
</script>

<style scoped>
 .search-results-round {
   position: relative;
   left: calc(100% - 1rem);
   width: 2rem;
   top:-2rem;
   height: auto;
 }

 .search-round {
   position: absolute;
    border-radius: 50%;
    background: rgba(0, 85, 255, 1);
    z-index: 1;
    padding: 2.5rem;
    transform-origin: 80% 50%;
    transform: translate(-50% -50%);
 }
</style>
