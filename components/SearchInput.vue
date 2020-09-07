<template>
  <div ref="search" class="search-header search-input-wrapper">
    <a class="link-search search-open">
      <svg class="icon-svg icon-search-svg">
        <use xlink:href="sprite.svg#icon-search" />
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
        v-model="searchString"
        type="text"
        placeholder="Поиск"
        class="search-input"
        ref="searchInput"
        @keyup.enter="goSearch()"
        @keyup.delete="deleteBlock(blocks.length - 1)"
      >
    </div>
    <a v-show="isShowCloseButton" class="search-close">
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
      paddingLeft: '6rem'
    }
  },
  computed: {
    isOpened () {
      return (this.$route.name === 'search' || this.$route.name === 'search-s')
    },
    isShowCloseButton () {
      return (this.$route.name === 'search' || this.$route.name === 'search-s')
    },
    width: {
      get () {
        const minus = this.$store.getters['header/isMobile'] ? '1.6rem' : '4.2rem'
        return (this.$route.name === 'search' || this.$route.name === 'search-s') ? `calc(100% - ${minus})` : '4.2rem'
      },
      set (newValue) {
        return newValue
      }
    }
  },
  mounted () {
    this.$root.$on('deleteBlock', (index) => { this.deleteBlock(index) })
    this.$root.$on('parseURL', (url) => { this.parseURL(url) })
    window.setTimeout(() => {
      if (this.blocks.length > 0) { console.log(this.$refs.wrapper.offsetWidth); this.paddingLeft = this.$refs.wrapper.offsetWidth + 10 + 'px' }
    }, 100)
  },
  methods: {
    open () {
      this.$root.$emit('openSearch')
      this.width = this.$store.getters['header/isMobile'] ? 'calc(100% - 1.6rem)' : 'calc(100% - 4.2rem)'
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
        if (this.blocks.length > 0) { this.paddingLeft = this.$refs.wrapper.offsetWidth + 10 + 'px' } else { this.paddingLeft = '6rem' }
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
