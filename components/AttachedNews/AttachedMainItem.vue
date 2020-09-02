<template>
  <div class="attached-news-main attached-news-item">
    <div class="attached-news-main-supwrapper">
      <div class="attached-news-main-black-bg" />
      <div class="attached-news-main-wrapper">
        <nuxt-link class="attached-news-main-inner" :to="post.category_link + '/' + post.slug">
          <picture v-if="post.thumb" class="attached-news-main-cover-cont">
            <img class="attached-news-main-cover-img" :src="post.thumb">
            <div class="attached-news-main-cover-gradient" />
          </picture>
          <div class="attached-news-text-over-pic">
            <div class="news-item-meta">
              <div class="news-rubric-link-wrapper">
                {{ post.category }}
              </div>
              <div class="publication-date">
                {{ post.date }}
              </div>
            </div>
            <div class="news-item-header-cont">
              <span class="news-item-header">{{ post.title }}</span><span class="news-item-subheader" />
            </div>
          </div>
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AttachedMainItem',
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>
