<template>
  <main>
    <article v-if="post.category_link === 'news'" class="single-post-cont">
      <h1 class="single-post-header">
        {{ post.post_title }}
      </h1>
      <div class="post-meta">
        <div class="publication-date">
          {{ post.date }}
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
              {{ post.date }}
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
            <span class="longread-post-header post-header">{{ post.title }}</span>
            <span class="longread-post-subheader">{{ post.subtitle }}</span>
          </div>
        </div>
      </div>
      <div v-html="post.post_content" />
      <div v-if="post.author" class="longread-author-cont">
        <nuxt-link class="longread-author-link link-underline" :to="'/search/?s=' + encodeURIComponent( JSON.stringify(['@'+ post.author.replace(' ','_')]))">Автор поста</nuxt-link>
      </div>
      <Tags :tags="post.tags" />
    </article>
    <LastNewsSingle />
    <LoadMore count="10" total="656" />
  </main>
</template>

<script>
import urls from '@/assets/js/urls'
import LastNewsSingle from '@/components/LastNews/LastNewsSingle'
import LoadMore from '@/components/LoadMore'
import Tags from '@/components/Tags'

export default {
  transition: {
    name: 'fade'
  },
  components: {
    LastNewsSingle,
    Tags,
    LoadMore
  },
  async asyncData ({ $axios, params, error }) {
    const request = {
      endpoint: `${urls.restURL}/single/${params.slug}`,
      headers: urls.restHeaders
    }
    try {
      const res = await $axios.get(request.endpoint)
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
  }
}

</script>
