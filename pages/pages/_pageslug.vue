<template>
  <main>
    <div class="news-body-cont">
      <div class="news-item-page-header-cont">
        <h1 class="news-item-page-header">
          {{ pageTitle }}
        </h1>
      </div>
      <div class="news-item-text-wrapper" v-html="pageContent" />
    </div>
  </main>
</template>

<script>
import urls from '@/assets/js/urls'

export default {
  transition: {
    name: 'fade'
  },
  async asyncData ({ $axios, params, error }) {
    try {
      const res = await $axios.get(urls.apiBaseURL + 'wp-json/wp/v2/pages/?slug=' + params.pageslug, urls.restHeaders)
      if (res.data.length > 0) {
        return {
          pageTitle: res.data[0].title.rendered,
          pageContent: res.data[0].content.rendered
        }
      } else {
        // eslint-disable-next-line no-throw-literal
        throw ({ statusCode: 404, message: 'Страница не найдена' })
      }
    } catch (error) {
      console.log(error)
    }
  }
}
</script>
