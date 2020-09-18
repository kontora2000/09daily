<template>
  <div class="gallery-lightbox-wrapper">
    <transition-group name="fade">
      <div v-show="isShow && images.length > 0" key="overlay" class="gallery-lightbox-overlay" />
      <div v-show="isShow && images.length > 0" key="cont" class="gallery-lightbox-cont">
        <div class="gallery-lightbox-body">
          <img class="gallery-lightbox-current-image" :src="currentImg">
          <div class="gallery-lightbox-numb">
            {{ currentIndex+1 }} / {{ imgCount }}
          </div>
        </div>
        <div class="gallery-lightbox-left" @click="left">
          <svg class="icon-arrow-svg icon-arrow-left-svg"><use xlink:href="~/static/sprite.svg#icon-arrow-big-to-left"></use></svg>
        </div>
        <div class="gallery-lightbox-right" @click="right">
          <svg class="icon-arrow-svg icon-arrow-right-svg"><use xlink:href="~/static/sprite.svg#icon-arrow-big-to-right"></use></svg>
        </div>
        <div class="gallery-lightbox-close" @click="close">
          <svg class="icon-svg icon-close-svg"><use xlink:href="~/static/sprite.svg#icon-close"></use></svg>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
export default {
  name: 'LightBox',
  data () {
    return {
      isShow: false,
      images: [],
      currentImg: null,
      currentIndex: 0,
      imgCount: 0,
      lastGalleryDataID: -1
    }
  },
  mounted () {
    this.$root.$on('openLightBox', (galleryData) => { this.load(galleryData); this.open() })
  },
  methods: {
    load (galleryData) {
      if (galleryData.images.length > 0) {
        for (const image of galleryData.images) {
          this.images.push(image.querySelector('img').getAttribute('src') ?? '')
        }
        this.imgCount = galleryData.images.length
        this.currentIndex = galleryData.currentIndex
        this.currentImg = this.images[this.currentIndex]
      }
    },
    left () {
      if (this.currentIndex !== 0) {
        this.currentIndex -= 1
      } else {
        this.currentIndex = (this.imgCount - 1)
      }
      this.currentImg = this.images[this.currentIndex]
    },
    right () {
      if (this.currentIndex !== (this.imgCount - 1)) {
        this.currentIndex += 1
      } else {
        this.currentIndex = 0
      }
      this.currentImg = this.images[this.currentIndex]
    },
    open () {
      document.body.style.overflow = 'hidden'
      this.isShow = true
    },
    close () {
      this.isShow = false
      document.body.style.overflow = 'scroll'
      this.$root.$emit('closeLightBox')
    }
  }
}
</script>

<style scoped>
  .gallery-lightbox-wrapper {
    z-index: 101;
  }

  .gallery-lightbox-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--Black92);
    z-index: 101;
    min-width: 100vw;
  }

  .gallery-lightbox-cont {
    position: fixed;
    display: flex;
    z-index: 102;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .gallery-lightbox-body {
    position: absolute;
    top: 3.2rem;
    left: 50%;
    transform: translateX(-50%);
  }

  .gallery-lightbox-current-image {
    max-width: calc(100vw - 3.2rem);
    height: 100%;
    max-height: 90vh;
  }

  .gallery-lightbox-close {
    cursor: pointer;
    position: absolute;
    left: 1.6rem;
    top: 3.2rem;
    transition: transform .175s ease-in-out;
    will-change: transform;
  }
  .gallery-lightbox-close:hover {
    transform: scale(1.075);
  }

  .gallery-lightbox-close .icon-close-svg>use {
    fill: var(--White56);
    transition: fill .175s ease-in-out;
  }
  .gallery-lightbox-close:hover .icon-close-svg>use {
    fill: var(--White100);
  }

  .gallery-lightbox-left,
  .gallery-lightbox-right {
    position: absolute;
    height: 100%;
    width: 10rem;
  }
  .gallery-lightbox-left:hover,
  .gallery-lightbox-right:hover {
    cursor: pointer;
  }

  .gallery-lightbox-left {
    left: 0;
  }

  .gallery-lightbox-right {
    right: 0;
  }

  .gallery-lightbox-left .icon-arrow-svg,
  .gallery-lightbox-right .icon-arrow-svg {
    top: calc(50vh - 1.8rem);
    position: absolute;
  }

  .gallery-lightbox-left .icon-arrow-svg {
    left: 1.6rem;
  }

  .gallery-lightbox-right .icon-arrow-svg {
    right: 1.6rem;
  }

  .icon-arrow-svg>use {
    fill: var(--White56);
  }
  .gallery-lightbox-left:hover>.icon-arrow-svg>use,
  .gallery-lightbox-right:hover>.icon-arrow-svg>use {
    fill: var(--White100);
  }

  .gallery-lightbox-numb {
    color: var(--White100);
    font-size: 2.4rem;
    text-align: center;
  }
</style>
