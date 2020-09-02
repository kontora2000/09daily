import urls from '@/assets/js/urls'

export const strict = false

export const state = () => ({
  menu: []
})

export const mutations = {
  setMenu (state, menu) {
    state.menu = menu
  }
}

export const actions = {
  async fetch ({ commit }) {
    const request = {
      endpoint: urls.restURL + '/menu/',
      headers: {
        ContentType: 'application/json',
        Accept: 'application/json',
        'Access-Control-Allow-Origin': '*'
      }
    }
    const menu = await this.$axios.get(request.endpoint, request.headers)
    commit('setMenu', menu.data)
  }
}

export const getters = {
  menu: s => s.menu
}
