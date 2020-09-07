export const strict = false

export const state = () => ({
  headerClass: 'header-main-page',
  isMobile: false,
  isSearch: false
})

export const mutations = {
  setHeaderClass (state, headerClass) {
    state.headerClass = headerClass
  },
  isMobile (state, val) {
    state.isMobile = val
  },
  isSearch (state, val) {
    state.isShowMenu = val
  }
}

export const actions = {
}

export const getters = {
  headerClass: s => s.headerClass,
  isMobile: s => s.isMobile,
  isSearch: s => s.isSearch
}
