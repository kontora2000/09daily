<template>
  <div class="search-request-item">
    <span class="search-request-item-delete" @click="$root.$emit('deleteBlock', ind)"><svg class="icon-search-request-item-delete-svg"><use xlink:href="/images/sprite.svg#icon-close-small" /></svg></span>
    {{ block }}
  </div>
</template>

<script>
export default {
  name: 'InputBlock',
  props: {
    block: {
      type: [String, Boolean],
      default: () => { return false }
    },
    ind: {
      type: [Number, Boolean],
      default: () => { return false }
    }
  }
}
</script>
</script>
