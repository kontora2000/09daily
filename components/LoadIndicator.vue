<template>
  <div class="load-indicator-wrapper">
    <div class="load-indicator">
      <div class="round round-1 scale-in" />
      <div class="round round-2 scale-in" />
      <div class="round round-3 scale-in" />
      <div class="round round-4 scale-in" />
      <div class="round round-5 scale-in" />
      <div class="round round-6 scale-in" />
    </div>
  </div>
</template>
<script>
export default {

}
</script>
<style scoped>
  .load-indicator-wrapper {
    min-width: 100vw;
    overflow: hidden;
    height: 16rem;
  }

  .load-indicator {
    max-width: 4rem;
    left: 50%;
    position: relative;
    top: 50%;
    transform: translate(-50%, -50%);
  }

</style>
