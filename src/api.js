const api = {
  
  get: async function(url) {

    const options = {method: 'GET'}

    try {
      const response = await fetch(url, options)
      return response
    } catch(e) {
      return e
    }

  },
  post: async function(url, paylodad) {

    const options = {
      method: 'POST',
      body: JSON.stringify(paylodad)
    }


    try {
      const response = await fetch(url, options)
      return response
    } catch(e) {
      return e
    }

  }

}

export default api