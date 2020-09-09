<template>
  <nav v-if="!this.$device.isMobile" class="menu-header">
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
  <div v-else class="menu-header menu-header-mobile">
    <div class="burger-icon-button" @click.prevent="toggleBurger()">
      <span class="burger-icon" :class="{ 'burger-icon-close': isShowBurgerMenu }">
        <span class="burger-icon-line" style="margin-top:1rem" />
        <span class="burger-icon-line" style="margin-top:1rem" />
      </span>
    </div>
    <div v-show="isShowBurgerMenu" class="burger-overlay">
      <transition name="fade">
        <nav class="mobile-nav" v-show="isShowBurgerMenu">
          <nuxt-link
            v-for="(menuItem, index) in menu"
            :key="menuItem.ID"
            :to=" '/' + menuItem.url"
            :class="[ 'menu-header-mobile-link', { 'active': activeItem === (index+1) }]"
            @click.native="setActive(index+1)"
          >
            {{ menuItem.title }}
          </nuxt-link>
        </nav>
      </transition>
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
      baseURL: urls.baseURL,
      isShowBurgerMenu: false
    }
  },
  methods: {
    toggleBurger () {
      if (this.$device.isMobile) {
        this.isShowBurgerMenu = !this.isShowBurgerMenu
        if (this.isShowBurgerMenu === true) {
          this.$root.$emit('openBurger')
        } else {
          this.$root.$emit('closeBurger')
        }
      }
    },
    setActive (index) {
      if (this.$device.isMobile) {
        this.isShowBurgerMenu = false
        this.$root.$emit('closeBurger')
      }
    }
  }
}
</script>

