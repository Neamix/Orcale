import helpers from './helper'

const plugin = {
    install (app) {
      app.config.globalProperties.collector = helpers
    }
}

export default plugin;

