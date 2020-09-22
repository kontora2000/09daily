<template>
  <div v-if="posts.length > 3 && !$device.isMobile" id="attached-news-old-society" class="attached-news-old-cont">
    <div class="cont-header-rubric cont-header">
      <nuxt-link class="cont-header-rubric-link" :to="slug">
        {{ slugTitle }}
      </nuxt-link>
    </div>
    <div ref="wrapper" class="attached-news-old-carousel-cont">
      <VueSlickCarousel
        ref="carousel"
        v-bind="options"
      >
        <div
          v-for="(post, index) in posts"
          :key="post.id"
          class="attached-news-old-item"
          >
          <nuxt-link
            class="attached-news-old-wrapper"
            :to="'/' + post.category_link + '/' + post.slug"
          >
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
                <span v-if="post.subheader" class="news-item-subheader">{{ post.subheader }}</span>
              </div>
            </div>
          </nuxt-link>
        </div>
      </VueSlickCarousel>
    </div>
    <div class="attached-news-old-nav">
      <button
        type="button"
        class="attached-news-old-nav-button attached-news-old-nav-button-left"
        @click.prevent="left()"
      >
        <svg class="icon-svg icon-arrow-big-to-left">
          <use xlink:href="sprite.svg#icon-arrow-big-to-left" />
        </svg>
      </button>
      <button
        type="button"
        class="attached-news-old-nav-button attached-news-old-nav-button-right"
        @click.prevent="right()"
      >
        <svg class="icon-svg icon-arrow-big-to-right">
          <use xlink:href="sprite.svg#icon-arrow-big-to-right" />
        </svg>
      </button>
    </div>
  </div>
  <!-- <div v-else id="attached-news-old-society" class="attached-news-old-cont">
    <client-only>
      <carousel v-bind="options">
        <slide v-for="post in posts" :key="post.id">
          <div
            class="attached-news-old-item"
            style="width:100%"
            :class="{'active': currentActive === index }"
          >
            <nuxt-link
              class="attached-news-old-wrapper"
              :to="'/' + post.category_link + '/' + post.slug"
            >
              <picture v-if="post.thumb" class="attached-news-old-cover-cont">
                <img class="attached-news-old-cover-img" :src="post.thumb">
                <div class="attached-news-old-cover-gradient" />
              </picture>
              <div class="attached-news-text-over-pic">
                <div class="news-item-meta">
                  <div class="publication-date">
                    {{ post.date }}
                  </div>
                </div>
                <div class="news-item-header-cont">
                  <span class="news-item-header">{{ post.title }}</span>
                  <span v-if="post.subheader" class="news-item-subheader">{{ post.subheader }}</span>
                </div>
              </div>
            </nuxt-link>
          </div>
        </slide>
      </carousel>
    </client-only>
    <div class="attached-news-old-nav">
      <button
        type="button"
        class="attached-news-old-nav-button attached-news-old-nav-button-left"
      >
        <svg class="icon-svg icon-arrow-big-to-left">
          <use xlink:href="sprite.svg#icon-arrow-big-to-left" />
        </svg>
      </button>
      <button
        type="button"
        class="attached-news-old-nav-button attached-news-old-nav-button-right"
      >
        <svg class="icon-svg icon-arrow-big-to-right">
          <use xlink:href="sprite.svg#icon-arrow-big-to-right" />
        </svg>
      </button>
    </div>
  </div> -->
</template>

<script>
import gsap from 'gsap'
import urls from '@/assets/js/urls'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

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
    const res = await this.$axios.get(
      urls.restURL + `/category_attached/${this.slug}/1`
    )
    this.posts = res.data.posts
    // this.leftShift = parseFloat(this.posts.length * 6 * 33.30)
    // this.currentActive = this.posts.length * 5 - 1
    // for (let i = 0; i < 5; i++) {
    //   this.posts.pop(...this.posts)
    //   this.posts.push(...this.posts)
    // }
    this.currentPost = res.data.posts[0]
    this.postCount = res.data.posts.length
  },
  data () {
    return {
      posts: [],
      currentPost: null,
      currentActive: 1,
      currentPos: 1,
      postCount: 0,
      leftShift: 0,
      isAnimated: false,
      animationDuration: 0.25,
      elems: [],
      options: {
        arrows: false,
        dots: false,
        centerMode: true,
        slidesToShow: 1,
        centerPadding: '25%'
      }
    }
  },
  mounted () {
    if (this.$refs.wrapper) { this.elems = this.$refs.wrapper.querySelectorAll('.attached-news-old-item') }
  },
  methods: {
    left () {
      // if (this.isAnimated === false) {
      //   this.isAnimated = true
      //   if (this.currentActive === 1) {
      //     const w = this.elems[this.currentActive].offsetWidth
      //     this.$nextTick(() => {
      //       gsap.to(this.$refs.wrapper, {
      //         x: `+=${w + 32}px`,
      //         duration: this.animationDuration,
      //         onComplete: () => {
      //           this.isAnimated = false
      //           this.currentActive = this.posts.length - 1
      //           this.elems = this.$refs.wrapper.querySelectorAll('.attached-news-old-item')
      //         }
      //       })
      //     })
      //     this.currentPost = this.posts[this.currentActive]
      //   } else {
      //     this.isAnimated = true
      //     const w = this.elems[this.currentActive].offsetWidth
      //     gsap.to(this.$refs.wrapper, {
      //       x: `+=${w + 32}px`,
      //       duration: this.animationDuration,
      //       onComplete: () => {
      //         this.isAnimated = false
      //         this.currentActive = this.currentActive - 1
      //       }
      //     })
      //   }
      // }
      this.$refs.carousel.prev()
      this.$refs.currentActive = this.$refs.currentActive - 1
    },
    right () {
      this.$refs.carousel.next()
      this.$refs.currentActive = this.$refs.currentActive + 1

      // if (this.isAnimated === false) {
      //   this.isAnimated = true
      //   if (this.currentActive === (this.posts.length - 2)) {
      //     const w = this.elems[this.currentActive].offsetWidth
      //     this.posts.push(...this.posts)
      //     gsap.to(this.$refs.wrapper, {
      //       x: `-=${w + 32}px`,
      //       duration: this.animationDuration,
      //       onComplete: () => {
      //         this.isAnimated = false
      //         this.currentActive = this.currentActive + 1
      //         this.elems = this.$refs.wrapper.querySelectorAll('.attached-news-old-item')
      //       }
      //     })
      //   } else {
      //     this.isAnimated = true
      //     const w = this.elems[this.currentActive].offsetWidth
      //     gsap.to(this.$refs.wrapper, {
      //       x: `-=${w + 32}px`,
      //       duration: this.animationDuration,
      //       onComplete: () => {
      //         this.isAnimated = false
      //         this.currentActive = this.currentActive + 1
      //       }
      //     })
      //   }
      // }
    }
  }
}
</script>

<style scoped>

.attached-news-old-item {
  margin-left:3.2rem ;
}

.attached-news-old-item a {
  width: 100%;
  height: 100%;
}

.attached-news-old-nav {
  position: relative;
    width: 99%;
    top: -26rem;

    z-index: 3;
}

.slick-current .attached-news-old-item  {
  opacity: 1;
}
</style>
