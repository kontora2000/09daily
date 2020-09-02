<template>
  <div class="menu-footer">
    <div class="rubrics-cont">
      <nuxt-link
        v-for="(menuItem, index) in menu"
        :key="menuItem.ID"
        :to=" '/' + menuItem.url"
        :class="[ 'menu-footer-link', { 'active': activeItem === (index+1) }]"
        @click="setActive(index+1)"
      >
        {{ menuItem.title }}
      </nuxt-link>
    </div>
    <div class="site-menu-cont">
      <nuxt-link class="menu-footer-link" to="page/redaction">Редакция</nuxt-link>
      <nuxt-link class="menu-footer-link" to="page/contacts">Контакты</nuxt-link>
      <nuxt-link class="menu-footer-link" to="page/adv">Реклама</nuxt-link>
    </div>
  </div>
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
