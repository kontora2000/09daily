<template>
  <div class="attached-news-default attached-news-item">
    <nuxt-link class="attached-news-default-wrapper" :to="'/' + post.category_link + '/' + post.slug">
      <picture v-if="post.thumb" class="attached-news-default-cover-cont">
        <img class="attached-news-default-cover-img" :src="post.thumb">
        <div class="attached-news-default-cover-gradient" />
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
          <span class="news-item-header">{{ post.title }}</span><span class="news-item-subheader">{{ post.subheader }}</span>
        </div>
      </div>
    </nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'AttachedDefaultItem',
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>
