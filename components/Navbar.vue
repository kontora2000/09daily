<template>
  <nav class="menu-header">
    <nuxt-link
      v-for="(menuItem, index) in menu"
      :key="menuItem.ID"
      :to=" '/' + menuItem.url"
      :class="[ 'menu-header-link', { 'active': activeItem === (index+1) }]"
      @click="setActive(index+1)"
    >
      {{ menuItem.title }}
    </nuxt-link>
  </nav>
</template>

<script>
import urls from '@/assets/js/urls'

export default {
  name: 'Navbar',
  async fetch () {
    if (this.$store.state.menu.menu.length === 0) {
      await this.$store.dispatch('menu/fetch')
    }
    this.menu = this.$store.state.menu.menu
  },
  data () {
    return {
      menu: [],
      activeItem: false,
      baseURL: urls.baseURL
    }
  }
}
</script>
