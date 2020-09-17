<template>
  <main>
    <article v-if="post.category_link === 'news'" class="single-post-cont">
      <h1 class="single-post-header">
        {{ post.post_title }}
      </h1>
      <div class="post-meta">
        <div class="publication-date">
          {{ post.day }} {{ post.month }} {{ post.year }}
        </div>
        <div class="news-rubric-link-wrapper">
          <nuxt-link class="rubric-link link-underline" :to="post.category_link">
            {{ post.category }}
          </nuxt-link>
        </div>
        <div v-if="post.author" class="post-author">
          <nuxt-link class="author-link link-underline" :to="'/search/?s=' + encodeURIComponent( JSON.stringify(['@'+ post.author.replace(' ','_')]))">
            {{ post.author }}
          </nuxt-link>
        </div>
        <div v-if="post.views" class="views-counter">
          {{ post.views }}
        </div>
        <div v-else class="views-counter">
          1 просмотр
        </div>
      </div>
      <picture v-if="post.thumb" class="single-post-cover">
        <img :src="post.thumb">
        <div class="post-pic-comment-cont">
          <div class="post-pic-comment" />
          <div class="post-pic-copyright">Роман Пилипей / EPA / Scanpix / LETA</div>
        </div>
      </picture>
      <div v-html="post.post_content" />
      <Tags />
    </article>
    <article v-else class="longread-post-cont">
      <div class="longread-header-cont">
        <div class="longread-header-black-bg" />
        <picture vi-if="post.thumb" class="longread-post-cover">
          <img class="longread-post-cover-img" :src="post.thumb">
          <div class="longread-post-cover-gradient" />
        </picture>
        <div vi-f="post.copyright" class="longread-post-pic-copyright post-pic-copyright">
          Роман Пилипей / EPA / Scanpix / LETA
        </div>
        <div class="longread-text-over-pic">
          <div class="post-meta">
            <div class="publication-date">
              {{ post.day }} {{ post.month }} {{ post.year }}
            </div>
            <div class="news-rubric-link-wrapper">
              <a class="rubric-link link-underline" href="#">Политика</a>
            </div>
            <div v-if="post.views" class="views-counter">
              {{ post.views }}
            </div>
            <div v-else class="views-counter">
              1 просмотр
            </div>
          </div>
          <div class="longread-post-header-cont">
            <span class="longread-post-header post-header">{{ post.post_title }}</span>
            <span class="longread-post-subheader">{{ post.subheader }}</span>
          </div>
        </div>
      </div>
      <p v-if="post.subtitle" class="longread-intro">
        {{ post.subtitle }}
      </p>
      <div ref="content" v-html="post.post_content" />
      <div v-if="post.author" class="longread-author-cont">
        <nuxt-link class="longread-author-link link-underline" :to="'/search/?s=' + encodeURIComponent( JSON.stringify(['@'+ post.author.replace(' ','_')]))">
          {{ post.author }}
        </nuxt-link>
      </div>
      <Tags :tags="post.tags" />
    </article>
    <LightBox v-show="isLightboxOpened" />
    <LastNewsSingle />
    <LoadMore count="10" total="656" />
  </main>
</template>

<script>
import urls from '@/assets/js/urls'
import LastNewsSingle from '@/components/LastNews/LastNewsSingle'
import LoadMore from '@/components/LoadMore'
import Tags from '@/components/Tags'
import LightBox from '@/components/LightBox'

export default {
  transition: {
    name: 'fade'
  },
  components: {
    LastNewsSingle,
    Tags,
    LightBox,
    LoadMore
  },
  async asyncData ({ $axios, params, error }) {
    const request = {
      endpoint: `${urls.restURL}/single/${params.slug}`,
      headers: urls.restHeaders
    }
    try {
      const res = await $axios.get(request.endpoint)
      console.log(res.data)
      if (res.data.day === false) {
        // eslint-disable-next-line no-throw-literal
        throw ({ statusCode: 404, message: 'Страница не найдена' })
      }
      return {
        post: res.data
      }
    } catch (e) {
      error(e)
    }
  },
  data () {
    return {
      isLightboxOpened: false
    }
  },
  mounted () {
    if (this.$refs.content) {
      const pars = this.$refs.content.querySelectorAll('p')
      for (let i = 0; i < pars.length; i++) {
        pars[i].className = 'longread-p'
      }
    }
    const images = document.querySelectorAll('.gallery-pic-wrapper')
    if (this.$device.isMobile === false) {
      for (let i = 0; i < images.length; i++) {
        images[i].addEventListener('click', () => {
          if (this.$device.isMobile === true) { return }
          if (!this.isLightboxOpened) {
            const gallerObj = {
              images: images[i].parentNode.querySelectorAll('.gallery-pic-wrapper'),
              currentIndex: i
            }
            this.$root.$emit('openLightBox', gallerObj)
            this.isLightboxOpened = true
          }
        })
      }
    }
    this.$root.$on('closeLightBox', () => { this.isLightboxOpened = false })
  },
  head () {
    return {
      title: this.post.post_title
    }
  }
}

</script>
