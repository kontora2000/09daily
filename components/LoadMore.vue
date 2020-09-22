<template>
  <div class="button-showmore-cont">
    <button class="button-showmore" @click.prevent="upload">
      <nobr><span class="icon-arrow-down">↓</span><span>Ещё&nbsp;{{ count }}</span><span class="button-showmore-items-quantity">из&nbsp;{{ total }}</span></nobr>
    </button>
  </div>
</template>

<script>
export default {
  name: 'LoadMore',
  props: {
    count: {
      type: String,
      default: '12'
    },
    total: {
      type: String,
      default: '1488'
    }
  },
  mounted () {
    if (this.count > this.total) { this.count = this.total }
  },
  methods: {
    upload () {
      this.$root.$emit('loadmore')
    }
  }

}
</script>
