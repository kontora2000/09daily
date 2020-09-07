<template>
  <footer v-if="showFooter">
    <div class="social-subscribe-cont">
      <Socials />
      <SubscribeForm />
    </div>
    <div class="bottom-cont">
      <NavBar />
      <div class="license-cont">
        <div class="license-text">Информационное агентство «09.DAILY»: свидетельство о регистрации СМИ ИА № ФС89-XXXXX выдано Федеральной службой по надзору в сфере связи, информационных технологий и массовых коммуникаций (Роскомнадзор) XX XX XXXX года.</div>
        <div class="copyrights-cont">
          <span class="copyright">©&nbsp;2020,</span><span class="age-restriction">16+</span>
        </div>
      </div>
      <div class="kontora-copyright">
          Сделано в&nbsp;<a class="kontora-sign" href="https://kontora.cc" target="_blank"><span class="link-underline">Конторе</span><sup>®</sup></a>
      </div>
    </div>
  </footer>
</template>
<script>
import Socials from '@/components/Footer/Socials.vue'
import SubscribeForm from '@/components/Footer/Subcribe.vue'
import NavBar from '@/components/Footer/NavBar.vue'

export default {
  name: 'Footer',
  components: {
    Socials,
    SubscribeForm,
    NavBar
  },
  computed: {
    showFooter: {
      get () {
        if (this.$route.name === 'search' || this.$route.name === 'search-s') { return false }
        return true
      },
      set (value) {
        this.showFooter = value
      }
    }
  }
}
</script>
