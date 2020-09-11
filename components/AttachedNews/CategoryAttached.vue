<template>
  <div v-if="posts.length > 3" id="attached-news-old-society" class="attached-news-old-cont">
    <div class="cont-header-rubric cont-header">
      <nuxt-link class="cont-header-rubric-link" :to="slug">
        {{ slugTitle }}
      </nuxt-link>
    </div>
    <div class="attached-news-old-carousel-cont">
      <div class="attached-news-old-carousel-wrapper" ref="wrapper">
        <div v-for="(post, index) in posts" :key="post.id" class="attached-news-old-item" :class="{'active': currentActive === index }">
          <nuxt-link class="attached-news-old-wrapper" :to="'/' + post.category_link + '/' + post.slug">
            <picture v-if="post.thumb" class="attached-news-old-cover-cont">
              <img class="attached-news-old-cover-img" :src="post.thumb">
              <div class="attached-news-old-cover-gradient" />
            </picture>
            <div class="attached-news-text-over-pic">
              <div class="news-item-meta">
                <div class="news-rubric-link-wrapper">
                  {{ post.category }}
                </div>
                <div class="publication-date">
                  {{ post.day }} {{ post.month }} {{ post.year }}
                </div>
              </div>
              <div class="news-item-header-cont">
                <span class="news-item-header">{{ post.title }}</span>
                <span v-if="post.subheader" class="news-item-subheader"> {{ post.subheader }}</span>
              </div>
            </div>
          </nuxt-link>
        </div>
      </div>
      <div class="attached-news-old-nav">
        <button type="button" class="attached-news-old-nav-button attached-news-old-nav-button-left" @click.prevent="left()">
          <svg class="icon-svg icon-arrow-big-to-left">
            <use xlink:href="sprite.svg#icon-arrow-big-to-left" />
          </svg>
        </button>
        <button type="button" class="attached-news-old-nav-button attached-news-old-nav-button-right" @click.prevent="right()">
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
      currentPost: null,
      currentActive: 1,
    }
  },
  methods: {
    left () {
      if (this.currentActive === 0) {
        this.currentActive = (this.posts.length - 1)
        gsap.to(this.wrapper, { x: '-=150', duration: 0.5 })
      } else {
        this.currentActive = this.currentActive - 1
      }
    },
    right () {
      if (this.currentActive === (this.posts.length - 1)) {
        this.currentActive = 0
      } else {
        this.currentActive = this.currentActive + 1
      }
    }
  }
}
</script>

<style scoped>
  .attached-news-old-carousel-wrapper {
    position: relative;
    width: auto;
    display: flex;
  }

  .attached-news-old-item {
    min-width: 33vw;
  }

  .attached-news-old-item a {
    width: 100%;
    height: 100%;
  }
</style>
