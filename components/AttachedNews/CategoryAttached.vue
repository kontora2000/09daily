<template>
  <div v-if="posts.length > 3" id="attached-news-old-society" class="attached-news-old-cont">
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
          v-for="post in posts"
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
                <!-- <div class="news-rubric-link-wrapper">
                  {{ post.category }}
                </div> -->
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
</template>

<script>
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
        centerPadding: this.$device.isMobile ? '10%' : '18%'
        // adaptiveHeight: this.$device.isMobile
      }
    }
  },
  mounted () {
    if (this.$refs.wrapper) { this.elems = this.$refs.wrapper.querySelectorAll('.attached-news-old-item') }
  },
  methods: {
    left () {
      this.$refs.carousel.prev()
    },
    right () {
      this.$refs.carousel.next()
    }
  }
}
</script>

<style scoped>

.attached-news-old-item a {
  width: 100%;
  height: 100%;
}

.attached-news-old-cont {
  position: relative;
}

.attached-news-old-cover-cont {
  display: block;
  position: relative;
  height: 100%;
}

.attached-news-old-cover-cont img {
  width: calc(100% - 3.2rem);
  object-fit: cover;
  position: relative;
}

.attached-news-old-cover-gradient {
  top:0;
  left: 0;
  width: calc(100% - 3.2rem);
}

.attached-news-text-over-pic {
  text-align: center;
  width: calc(100% - 3.2rem);
  position: relative;
  bottom: 10rem;
  z-index: 1;
  object-fit: cover;

}

.slick-current .attached-news-old-item  {
  opacity: 1;
}

  @media (max-width: 460px) {
    .attached-news-old-item span {
      font-size: 2.2rem;
      line-height: 2.4rem;
    }

    .attached-news-old-nav {
      display: none;
    }
  }

  @media (max-width: 360px) {
    .attached-news-old-item span {
      font-size: 1.8rem;
      line-height: 2.2rem;
    }

    .attached-news-old-nav {
      display: none;
    }
  }
</style>
