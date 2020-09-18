<template>
  <div ref="search" class="search-header search-input-wrapper">
    <a class="link-search search-open">
      <svg class="icon-svg icon-search-svg">
        <use xlink:href="~/static/sprite.svg#icon-search" />
      </svg>
    </a>
    <div class="search-input-contenteditable">
      <div ref="wrapper" class="search-request-wrapper">
        <template v-if="blocks.length">
          <InputBlock
            v-for="(block, index) in blocks"
            :key="index"
            :block="block"
            :ind="index"
            class="search-request-item"
          />
        </template>
      </div>
      <input
        id="search-input"
        ref="searchInput"
        v-model="searchString"
        type="text"
        class="search-input"
        :style="{ 'padding-left': paddingLeft }"
        :placeholder="placeholder"
        @keyup.enter="goSearch()"
      >
    </div>
    <a v-show="isShowCloseButton" class="search-close" @click.prevent="close">
      <div class="icon-cross">
        <span class="icon-cross-line" />
        <span class="icon-cross-line" />
      </div>
    </a>
  </div>
</template>

<script>
import searchParser from '@/assets/js/searchParser'
import urls from '@/assets/js/urls'
import InputBlock from '@/components/InputBlock'

export default {
  name: 'SearchInput',
  components: {
    InputBlock
  },
  data () {
    return {
      isAnimate: false,
      searchString: '',
      blocks: [],
      paddingLeft: '6rem',
      isLoading: false,
      placeholder: 'Поиск'
    }
  },
  computed: {
    isOpened () {
      return (this.$route.name === 'search' || this.$route.name === 'search-s')
    },
    isShowCloseButton () {
      return (this.$route.name === 'search' || this.$route.name === 'search-s')
    }
  },
  mounted () {
    this.$refs.searchInput.focus()
    this.$root.$on('deleteBlock', (index) => { this.deleteBlock(index) })
    this.$root.$on('parseURL', (url) => { this.parseURL(url) })
    window.setTimeout(() => {
      if (this.blocks.length > 0) {
        console.log(this.$refs.wrapper.offsetWidth)
        this.paddingLeft = this.$refs.wrapper.offsetWidth + 10 + 'px'
        this.placeholder = ''
      }
    }, 100)
  },
  methods: {
    open () {
      this.$root.$emit('openSearch')
      // gsap.set(this, { isShowCloseButton: true, delay: 0.5 })
      this.$refs.searchInput.focus()
      this.paddingLeft = '6rem'
    },
    close () {
      this.searchString = ''
      this.blocks = []
      this.$refs.searchInput.blur()
      this.$router.go(-1)
      window.setTimeout(() => {
        this.$root.$emit('closeSearch')
      }, 1000)
    },
    goSearch () {
      if (this.searchString.trim() === '') {
        this.searchString = ''
        return
      }
      const newWords = searchParser.stringToWords(this.searchString)
      const newBlocks = searchParser.parseWords(newWords)
      if (newBlocks.length === 0) { this.$root.$emit('goSearch', '') }
      this.blocks.push(...newBlocks)
      this.blocks = Array.from(new Set(this.blocks))
      this.$nextTick(() => {
        if (this.blocks.length > 0) {
          this.paddingLeft = this.$refs.wrapper.offsetWidth + 10 + 'px'
          this.placeholder = ''
        } else {
          this.paddingLeft = '6rem'
          this.placeholder = 'Поиск'
        }
      })
      this.searchString = ''
      const restString = searchParser.blocksToRestString(this.blocks)
      const urlString = searchParser.blocksToURLString(this.blocks)
      window.history.replaceState({ }, '', urls.baseURL + 'search/?s=' + urlString)
      this.$root.$emit('goSearch', restString)
    },
    deleteBlock (ind) {
      if (ind === 0) {
        this.paddingLeft = '6rem'
        this.placeholder = 'Поиск'
        this.$root.$emit('goSearch', '')
        this.$refs.searchInput.focus()
      }
      this.blocks.splice(ind, 1)
      this.goSearch()
    },
    parseURL (url) {
      if (url === '') { return }
      this.blocks = searchParser.URLtoBlocks(url)
      const restString = searchParser.blocksToRestString(this.blocks)
      this.$root.$emit('goSearch', restString)
    }
  }

}
</script>
