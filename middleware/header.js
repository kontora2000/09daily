export default function ({ route, isMobile, store }) {
  if (isMobile) {
    store.commit('header/isBurger', true)
    store.commit('header/isMobile', true)
    store.commit('header/isLogo', false)
    return
  }
  if (process.server) {
    switch (route.name) {
      case 'search': case 'search-s' :
        store.commit('header/setHeaderClass', 'header-search-page header-search')
        break
      case 'index' :
        store.commit('header/setHeaderClass', 'header-main-page header-index')
        store.commit('header/isBurger', false)
        store.commit('header/isLogo', true)
        store.commit('header/isShowMenu', true)
        break
      case 'category' :
        store.commit('header/setHeaderClass', 'header-inner-page header-category')
        store.commit('header/isBurger', false)
        store.commit('header/isLogo', false)
        store.commit('header/isShowMenu', true)
        break
      case 'category-slug': case 'page-pageslug' :
        store.commit('header/setHeaderClass', 'header-inner-page header-single')
        store.commit('header/isBurger', true)
        store.commit('header/isShowMenu', false)
        break
    }
  }
}
