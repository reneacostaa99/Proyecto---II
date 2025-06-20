 export default {
     head: {
       title: 'POS',
       htmlAttrs: {
         lang: 'en'
       },
       meta: [
         { charset: 'utf-8' },
         { name: 'viewport', content: 'width=device-width, initial-scale=1' },
         { hid: 'description', name: 'description', content: '' },
         { name: 'format-detection', content: 'telephone=no' }
       ],
       link: [
         { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
         { rel: 'stylesheet', href: '/assets/css/nucleo-icons.css' },
         { rel: 'stylesheet', href: '/assets/css/nucleo-svg.css' },
         { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' },
         { rel: 'stylesheet', href: '/assets/css/soft-ui-dashboard.min.css' },
       ],
       script: [
         { src: "https://kit.fontawesome.com/42d5adcbca.js" },    
         { src: "/assets/js/core/popper.min.js" },
         { src: "/assets/js/core/bootstrap.min.js" },
         { src: "/assets/js/plugins/perfect-scrollbar.min.js" },
         { src: "/assets/js/plugins/smooth-scrollbar.min.js" },
         { src: "/assets/js/plugins/dropzone.min.js" },
         { src: "/assets/js/plugins/dragula/dragula.min.js" },
         { src: "/assets/js/plugins/jkanban/jkanban.js" },
         { src: "/assets/js/plugins/chartjs.min.js" },
       ]
     },
     css: [
      '@fortawesome/fontawesome-free/css/all.min.css',
     ],
     plugins: [
       '~/plugins/api',
       '~/plugins/printer',   
     ],
     components: true,
     buildModules: [],
     modules: ['@nuxtjs/axios', 'vue-sweetalert2/nuxt'],
     build: {}
   }