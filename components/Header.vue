<template>
  <header :class="headerClass">
    <LogoHeader />
    <div class="search-header">
      <nuxt-link class="link-search search-open" to="/search/">
        <svg class="icon-svg icon-search-svg">
          <use xlink:href="~/static/sprite.svg#icon-search" />
        </svg>
      </nuxt-link>
    </div>
    <Navbar v-if="!isSearch" />
    <SearchInput v-if="isSearch" />
  </header>
</template>

<script>
import LogoHeader from '@/components/LogoHeader.vue'
import Navbar from '@/components/Navbar.vue'
import SearchInput from '@/components/SearchInput.vue'

export default {
  name: 'Header',
  components: {
    LogoHeader,
    Navbar,
    SearchInput
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
        if (this.$route.name === 'search' || this.$route.name === 'search-s') { return 'header-black search-header-opened' }
        return 'header-inner-page'
      },
      set (value) {
        this.headerClass = value
      }
    },
    isSearch () {
      if (this.$route.name === 'search' || this.$route.name === 'search-s') { return true }
      return false
    }
  }

}
</script>
