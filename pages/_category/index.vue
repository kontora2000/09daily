<template>
  <main>
    <div class="main-grid category-page">
      <AdvCat :number="1" />
      <AdvCat :number="2" />
      <CatNewsItem v-for="post in posts" :key="post.id" :post="post" :category="categoryName" />
    </div>
    <LoadMore v-if="isNeedToUpload && !isLoadedOnce" count="10" :total="allCount" />
    <infinite-loading
      v-if="isLoadedOnce"
      @infinite="load"
    >
      <div slot="spinner">
        <LoadIndicator />
      </div>
    </infinite-loading>
  </main>
</template>

<script>
import urls from '@/assets/js/urls'
import og from '@/assets/js/og'
import CatNewsItem from '@/components/CatNewsItem'
import AdvCat from '@/components/AdvCat'
import LoadMore from '@/components/LoadMore'
import LoadIndicator from '@/components/LoadIndicator'

export default {
  transition: {
    name: 'fade'
  },
  components: {
    LoadMore,
    CatNewsItem,
    AdvCat,
    LoadIndicator
  },
  async asyncData ({ params, $axios, error }) {
    try {
      const res = await $axios.get(`${urls.restURL}/category/${params.category}/1`)
      // eslint-disable-next-line no-throw-literal
      if (res.data === undefined) { throw ({ statusCode: 404, message: 'Страница не найдена' }) }
      return {
        posts: res.data.posts,
        isNeedToUpload: res.data.allCount > res.data.posts.length,
        categoryID: res.data.posts[0].category_id,
        categoryName: res.data.categoryName,
        categoryDescription: res.data.categoryDescr,
        allCount: res.data.allCount
      }
    } catch (e) {
      error(e)
    }
  },
  data () {
    return {
      category: this.$route.params.category,
      isLoadedOnce: false,
      page: 2,
      isLoading: false
    }
  },
  mounted () {
    this.$root.$on('loadmore', this.upload)
  },
  methods: {
    async upload ($state) {
      const res = await this.$axios.get(`${urls.restURL}/category/${this.$route.params.category}/${this.page}`)
      if (res.data.posts.length > 0) {
        this.posts.push(...res.data.posts)
        this.page += 1
        if ($state) { $state.loaded = true }
      } else if ($state) { $state.complete = true }
    }
  },
  head () {
    const meta = [
      { hid: 'og:title', name: 'og:title', content: '09daily - ' + this.categoryName },
      { hid: 'og:description', name: 'og:description', content: 'Рубрика ' + this.categoryDescription },
      { hid: 'og:url', name: 'og:url', content: urls.baseURL + this.$route.fullPath },
      { hid: 'twitter-description', name: 'twitter:description', content: this.categoryDescription },
      { hid: 'twitter-image', name: 'twitter:image', content: '' },
      { hid: 'og-image', name: 'og:image', content: '' },
      { hid: 'description', name: 'description', content: this.categoryDescription }
    ]
    meta.push(...og)
    return {
      title: '09daily - ' + this.categoryName,
      meta
    }
  }
}
</script>
