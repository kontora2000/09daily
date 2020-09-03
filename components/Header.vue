<template>
  <header :class="headerClass">
    <LogoHeader />
    <Navbar />
    <div class="search-header">
      <nuxt-link class="link-search search-open" :to="'search/?s=' + searchString">
        <svg class="icon-svg icon-search-svg">
          <use xlink:href="sprite.svg#icon-search" />
        </svg>
      </nuxt-link>
    </div>
  </header>
</template>

<script>
import LogoHeader from '@/components/LogoHeader.vue'
import Navbar from '@/components/Navbar.vue'

export default {
  name: 'Header',
  components: {
    LogoHeader,
    Navbar
  },
  data () {
    return {
      searchString: ''
    }
  },
  computed: {
    headerClass: {
      get () {
        if (this.$route.name === 'index') { return 'header-black' }
        if (this.$route.name === 'category-slug' && this.$route.params.category !== 'news') { return 'header-black' }

        if (this.$route.name === 'category-slug' && this.$route.params.category === 'news') { return 'header-white' }

        if (this.$route.name === 'category' && !this.$route.params.slug) { return 'header-white' }
        if (this.$route.name === 'search' || this.$route.name === 'search-s') { return 'header-black' }
        return 'header-inner-page'
      },
      set (value) {
        this.headerClass = value
      }
    }
  }

}
</script>
