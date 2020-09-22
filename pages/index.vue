<template>
  <main>
    <div class="main-grid">
      <AttachedMainItem :post="attachedMainPost" />
      <AttachedDefaultItem v-for="mypost in attachedDefaultPosts" :key="mypost.id" :post="mypost" />
      <LastNews />
      <Adv :number="0+1" />
      <Adv :number="0+2" />
      <div class="ad-mainpage-3-cont">
        <div class="ad-mainpage-3-wrapper">
          <a class="ad-mainpage-link" href="#">
            <img class="ad-mainpage-img-vertical ad-img" src="img/ad/mainpage-1.png">
          </a>
          <div class="ad-prices-link-wrapper">
            <nuxt-link class="ad-prices-link link-underline" to="/adv">
              Разместить рекламу
            </nuxt-link>
          </div>
        </div>
      </div>
      <!-- <div id="attached-news-old-society" class="attached-news-old-cont">
        <div class="cont-header-rubric cont-header">
          <a class="cont-header-rubric-link" href="#">Общество</a>
        </div>
        <div class="attached-news-old-carousel-cont">
          <el-carousel :interval="4000" type="card" arrow="never" indicator-position="none">
            <el-carousel-item v-for="item in 3" :key="item" :class="'attached-news-old-cover-cont'">
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
            </el-carousel-item>
          </el-carousel>
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
      </div> -->
      <CategoryAttached slug="culture" slug-title="Культура" />
      <NewsItem v-for="post in simplePosts" :key="post.id" :post="post" />
    </div>
    <template v-if="!isLoadedOnce && !isLoading">
      <LoadMore :total="allCount + ''" />
    </template>
    <template v-if="isLoadedOnce">
      <infinite-loading
        v-if="isLoadedOnce"
        @infinite="load"
      >
        <div slot="spinner" />
        <div slot="no-more" />
      </infinite-loading>
    </template>
    <LoadIndicator v-if="isLoading && !nothingToLoad" />
  </main>
</template>

<script>
import urls from 'assets/js/urls.js'

import AttachedMainItem from '@/components/AttachedNews/AttachedMainItem'
import AttachedDefaultItem from '@/components/AttachedNews/AttachedDefaultItem'
import CategoryAttached from '@/components/AttachedNews/CategoryAttached'
import NewsItem from '@/components/NewsItem'
import LastNews from '@/components/LastNews/LastNews'
import LoadMore from '@/components/LoadMore'
import Adv from '@/components/Adv'
import LoadIndicator from '@/components/LoadIndicator'

export default {
  components: {
    LastNews,
    AttachedMainItem,
    AttachedDefaultItem,
    CategoryAttached,
    NewsItem,
    LoadMore,
    Adv,
    LoadIndicator
  },
  transition: {
    name: 'fade'
  },
  async asyncData ({ $axios }) {
    const request = {
      endpoint: `${urls.restURL}/attached/1`,
      headers: {
        ContentType: 'application/json',
        Accept: 'application/json'
      }
    }
    const attachedPostsRes = await $axios.get(request.endpoint, request.headers)
    const simplePostsRes = await $axios.get(`${urls.restURL}/posts/1`, request.headers)
    return {
      attachedMainPost: attachedPostsRes.data.posts[0],
      attachedDefaultPosts: attachedPostsRes.data.posts.slice(1, 4),
      simplePosts: simplePostsRes.data.posts,
      allCount: simplePostsRes.data.allCount,
      isPageLoaded: true
    }
  },
  data () {
    return {
      page: 2,
      isLoadedOnce: false,
      isLoading: false,
      nothingToLoad: false
    }
  },
  mounted () {
    this.$root.$on('loadmore', this.load)
    const images = document.querySelectorAll('.gallery-pic-wrapper')
    if (this.$store.getters['header/isMobile'] === false) {
      for (let i = 0; i < images.length; i++) {
        images[i].addEventListener('click', () => {
          if (this.$store.getters['header/isMobile'] === true) { return }
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
  },
  methods: {
    load ($state) {
      if (this.isLoading === true) { return }
      if (this.isPageLoaded === false) { return }
      if (this.nothingToLoad === true) { return }
      this.isLoading = true
      window.setTimeout(async ($state) => {
        const res = await this.$axios.get(`${urls.restURL}/posts/${this.page}`)
        this.isLoading = false
        if (res.data.posts.length > 0) {
          this.simplePosts.push(...res.data.posts)
          this.page = this.page + 1
          this.isLoadedOnce = true
          if ($state) { $state.loaded() }
        } else if ($state) { $state.complete(); this.nothingToLoad = true; this.isLoading = false }
      }, 1000)
    }
  }
}
</script>
