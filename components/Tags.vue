<template>
  <div v-if="tags.length > 0" class="post-tags-cont">
    <nuxt-link
      v-for="tag in tags"
      :key="tag.id"
      :to="'/search/?s=' + encodeURIComponent( JSON.stringify(['#'+ tag.name.replace(' ','_')]))"
      class="post-tag"
    >
      {{ tag.name }}
    </nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'Tags',
  props: {
    tags: {
      type: Array,
      default: () => []
    }
  }
}
</script>
