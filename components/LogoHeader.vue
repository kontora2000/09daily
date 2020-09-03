<template>
  <div class="logo-header">
    <div class="logo-circle-gradient">
      <div class="round round-1 scale-in" />
      <div class="round round-2 scale-in" />
      <div class="round round-3 scale-in" />
      <div class="round round-4 scale-in" />
      <div class="round round-5 scale-in" />
      <div class="round round-6 scale-in" />
    </div>
    <nuxt-link class="logo-link" to="/">
      <div class="logo-svg"></div>
    </nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'LogoHeader',
  mounted () {
    document.addEventListener('DOMContentLoaded', () => {
      const r1 = document.querySelector('.round-1')
      const r2 = document.querySelector('.round-2')
      const r3 = document.querySelector('.round-3')
      const r4 = document.querySelector('.round-4')
      const r5 = document.querySelector('.round-5')
      const r6 = document.querySelector('.round-6')

      document.querySelector('.logo-header').addEventListener(
        'mouseenter',
        () => {
          r1.style.animationDelay = '0s !important'
          r2.style.animationDelay = '0.5s !important'
          r3.style.animationDelay = '1s !important'
          r4.style.animationDelay = '1.5s !important'
          r5.style.animationDelay = '2s !important'
          r6.style.animationDelay = '2.5s !important'
          r1.classList.add('scale-in-fast')
          r2.classList.add('scale-in-fast')
          r3.classList.add('scale-in-fast')
          r4.classList.add('scale-in-fast')
          r5.classList.add('scale-in-fast')
          r6.classList.add('scale-in-fast')
        })
      document.querySelector('.logo-header').addEventListener(
        'mouseleave',
        () => {
          r1.style.animationDelay = '0s !important'
          r2.style.animationDelay = '1s !important'
          r3.style.animationDelay = '2s !important'
          r4.style.animationDelay = '3s !important'
          r5.style.animationDelay = '4s !important'
          r6.style.animationDelay = '5s !important'
          r1.classList.remove('scale-in-fast')
          r2.classList.remove('scale-in-fast')
          r3.classList.remove('scale-in-fast')
          r4.classList.remove('scale-in-fast')
          r5.classList.remove('scale-in-fast')
          r6.classList.remove('scale-in-fast')
        })
    })
  }
}
</script>
