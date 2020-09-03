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
      <NewsItem v-for="post in simplePosts" :key="post.id" :post="post" />
    </div>
    <LoadMore count="10" :total="allCount" />
  </main>
</template>

<script>
import urls from 'assets/js/urls.js'

import AttachedMainItem from '@/components/AttachedNews/AttachedMainItem'
import AttachedDefaultItem from '@/components/AttachedNews/AttachedDefaultItem'
import NewsItem from '@/components/NewsItem'
import LastNews from '@/components/LastNews/LastNews'
import LoadMore from '@/components/LoadMore'
import Adv from '@/components/Adv'

export default {
  components: {
    LastNews,
    AttachedMainItem,
    AttachedDefaultItem,
    NewsItem,
    LoadMore,
    Adv
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
      allCount: simplePostsRes.data.allCount
    }
  }
}
</script>
