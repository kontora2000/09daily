<template>
  <div v-if="post.attached !== true" class="news-item-cont news-item">
    <nuxt-link class="news-item-link" :to="post.link">
      <picture v-if="post.thumb" class="news-item-cover">
        <img class="news-item-cover-img" :src="post.thumb">
      </picture>
      <div class="news-item-meta">
        <div class="news-rubric-link-wrapper">
          {{ category }}
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
  <div v-else class="attached-news-default attached-news-item">
    <nuxt-link class="attached-news-default-wrapper" :to="post.link">
      <picture v-if="post.thumb" class="attached-news-default-cover-cont">
        <img class="attached-news-default-cover-img" :src="post.thumb">
        <div class="attached-news-default-cover-gradient" />
      </picture>
      <div class="attached-news-text-over-pic">
        <div class="news-item-meta">
          <div class="news-rubric-link-wrapper">
            {{ category }}
          </div>
          <div class="publication-date">
            {{ post.date }}
          </div>
        </div>
        <div class="news-item-header-cont">
          <span class="news-item-header">{{ post.title }}</span><span class="news-item-subheader">Эксперты о ситуации на рынке труда Северного Кавказа</span>
        </div>
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
    },
    category: {
      type: String,
      default: 'Новости'
    }
  }
}
</script>
