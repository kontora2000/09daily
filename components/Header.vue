<template>
  <header :class="headerClass" :style="{ 'height': headerHeight }">
    <transition name="fade">
      <LogoHeader v-if="!isOpenBurger" />
    </transition>
    <transition name="fade">
      <div v-if="!isOpenBurger" class="search-header">
        <nuxt-link class="link-search search-open" to="/search/">
          <svg class="icon-svg icon-search-svg">
            <use xlink:href="~/static/sprite.svg#icon-search" />
          </svg>
        </nuxt-link>
      </div>
    </transition>
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
      searchString: '',
      isOpenBurger: false,
      headerHeight: ''
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
  },
  mounted () {
    this.$root.$on('openBurger', this.hideLogoAndSearch)
    this.$root.$on('closeBurger', this.showLogoAndSearch)
  },
  methods: {
    hideLogoAndSearch () {
      this.isOpenBurger = true
      this.headerHeight = '35rem'
    },
    showLogoAndSearch () {
      this.isOpenBurger = false
      this.headerHeight = '5.6rem'
    }
  }

}
</script>

<style scoped>
 header {
   transition: height 0.2s ease;
 }
</style>
