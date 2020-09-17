<template>
  <div class="last-news-item news-item">
    <nuxt-link class="last-news-item-link" :to="post.link">
      <picture v-if="post.thumb && (number === 1 || number < 0) && ($device.isMobile === false)" class="news-item-cover">
        <img class="news-item-cover-img" :src="post.thumb">
      </picture>
      <div class="news-item-meta">
        <div class="publication-date">
          {{ post.date }}
        </div>
      </div>
      <div class="news-item-header-cont" :class="{ 'font-white': isWhite}">
        <span class="news-item-header">{{ post.title }}</span>
        <span class="news-item-subheader"> {{ post.subheader }}</span>
      </div>
    </nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'Item',
  props: {
    post: {
      type: Object,
      default: null,
      required: true
    },
    number: {
      type: Number,
      default: 1
    }
  },
  data () {
    return {
      fontColor: '#000'
    }
  },
  computed: {
    isWhite () {
      if (this.number < 0) { return false }
      if (this.number > 3) {
        return false
      } else {
        return true
      }
    }
  },
  mounted () {
    // window.setTimeout(() => {
    //   const gradientH = document.querySelector('.attached-news-main').offsetHeight
    //   const y = this.cumulativeOffset(this.$el)
    //   if (y < gradientH) { this.fontColor = '#fff' } else { this.fontColor = '#000000' }
    //   console.log(gradientH)
    //   console.log(y)
    // }, 100)
  },
  methods: {
    cumulativeOffset (element) {
      let top = 0; let left = 0
      do {
        top += element.offsetTop || 0
        left += element.offsetLeft || 0
        element = element.offsetParent
      } while (element)
      return {
        top,
        left
      }
    }
  }
}
</script>
