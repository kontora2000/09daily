export default {
  baseURL: 'http://localhost:3000/',
  apiBaseURL: 'https://09daily.ru/',
  restURL: 'https://api.09daily.ru/wp-json/daily/v1',
  socials: {
    twitter: 'https://twitter.com/09daily.ru',
    telegram: 'https://teleg.run/09daily.ru',
    facebook: 'https://facebook.com/09daily.ru',
    vk: 'https://vk.com/09daily.ru'
  },
  restHeaders: {
    headers: {
      ContentType: 'application/json',
      Accept: 'application/json'
    }
  }
}
