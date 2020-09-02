<template>
  <div class="post-tags-cont">
    <nuxt-link
      v-for="tag in tags"
      :key="tag.id"
      :to="'/search/s?&t=' + tag.name.replace(' ', '_')"
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
      required: true,
      default: () => []
    }
  }
}
</script>
