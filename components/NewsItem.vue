<template>
  <div class="news-item-cont news-item">
    <nuxt-link class="news-item-link" :to="post.category_link + '/' + post.slug">
      <picture v-if="post.thumb" class="news-item-cover">
        <img class="news-item-cover-img" :src="post.thumb">
      </picture>
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
    </nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'NewsItem',
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>
