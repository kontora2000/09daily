<template>
  <div v-if="posts.length > 0" id="attached-news-old-society" class="attached-news-old-cont">
    <div class="cont-header-rubric cont-header">
      <nuxt-link class="cont-header-rubric-link" :to="slug">{{ slugTitle }}</nuxt-link>
    </div>
    <div class="attached-news-old-carousel-cont">
      <div class="attached-news-old-carousel-wrapper">
        <div class="attached-news-old-item">
          <a class="attached-news-old-wrapper" href="#">
            <picture class="attached-news-old-cover-cont">
              <img class="attached-news-old-cover-img" src="img/news-covers/1.png">
              <div class="attached-news-old-cover-gradient" />
            </picture>
            <div class="attached-news-text-over-pic">
              <div class="news-item-meta">
                <div class="news-rubric-link-wrapper">Политика</div>
                <div class="publication-date">Вчера в 22:44</div>
              </div>
              <div class="news-item-header-cont">
                <span class="news-item-header">Депутат Госдумы от Ставрополья показал, как в него проник коронавирус</span><span class="news-item-subheader" />
              </div>
            </div>
          </a>
        </div>
        <div class="attached-news-old-item active">
          <a class="attached-news-old-wrapper" href="#">
            <picture class="attached-news-old-cover-cont">
              <img class="attached-news-old-cover-img" src="img/news-covers/1.png">
              <div class="attached-news-old-cover-gradient" />
            </picture>
            <div class="attached-news-text-over-pic">
              <div class="news-item-meta">
                <div class="news-rubric-link-wrapper">Политика</div>
                <div class="publication-date">Вчера в 22:44</div>
              </div>
              <div class="news-item-header-cont">
                <span class="news-item-header">Депутат Госдумы от Ставрополья показал, как в него проник коронавирус</span><span class="news-item-subheader" />
              </div>
            </div>
          </a>
        </div>
        <div class="attached-news-old-item">
          <a class="attached-news-old-wrapper" href="#">
            <picture class="attached-news-old-cover-cont">
              <img class="attached-news-old-cover-img" src="img/news-covers/1.png">
              <div class="attached-news-old-cover-gradient" />
            </picture>
            <div class="attached-news-text-over-pic">
              <div class="news-item-meta">
                <div class="news-rubric-link-wrapper">Политика</div>
                <div class="publication-date">Вчера в 22:44</div>
              </div>
              <div class="news-item-header-cont">
                <span class="news-item-header">Депутат Госдумы от Ставрополья показал, как в него проник коронавирус</span><span class="news-item-subheader" />
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="attached-news-old-nav">
        <button type="button" class="attached-news-old-nav-button attached-news-old-nav-button-left">
          <svg class="icon-svg icon-arrow-big-to-left">
            <use xlink:href="sprite.svg#icon-arrow-big-to-left" />
          </svg>
        </button>
        <button type="button" class="attached-news-old-nav-button attached-news-old-nav-button-right">
          <svg class="icon-svg icon-arrow-big-to-right">
            <use xlink:href="sprite.svg#icon-arrow-big-to-right" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import urls from '@/assets/js/urls'

export default {
  name: 'CategoryAttached',
  props: {
    slug: {
      type: String,
      default: 'news'
    },
    slugTitle: {
      type: String,
      default: 'Новости'
    }
  },
  async fetch () {
    const res = await this.$axios.get(urls.restURL + `/category_attached/${this.slug}/1`)
    this.posts = res.data.posts
    this.currentPost = res.data.posts[0]
  },
  data () {
    return {
      posts: [],
      currentPost: null
    }
  }
}
</script>
