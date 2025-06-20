export default function ({ $axios }, inject) {
    // Create a custom axios instance
    const printer = $axios.create({
      headers: {
        common: {
          Accept: 'text/plain, */*'
        }
      }
    })
  
    // Set baseURL to something different
    //api.setBaseURL('http://localhost/Proyecto2/api_titular%20-%20copia/public/api')
    // Inject to context as $api
    inject('printer', printer)
  }