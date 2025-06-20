export default function ({ $axios }, inject) {
    // Create a custom axios instance
    const api = $axios.create({
      headers: {
        common: {
          Accept: 'text/plain, */*'
        }
      }
    })
  
    // Set baseURL to something different
    let url = 'http://localhost/Proyecto2/api_titular/public/api/'
    api.url = url
    api.setBaseURL(url)
    // Inject to context as $api
    inject('api', api)
  }