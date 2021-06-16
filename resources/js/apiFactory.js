async function performApiCall(url, method, auth=false, body, contentType = '') {
    try {
        // Request configuration
        let reqConfig = {
            method: method,
            body: body,
            headers: {
                Accept: 'application/json'
            }
        }
        if (contentType) {
            reqConfig.headers['Content-type'] = contentType
        }
        if (auth) {
            const token = localStorage.getItem('token');
            reqConfig.headers.Authorization = token;
        }

        // Perform request
        const request = await fetch(url, reqConfig);
        const response = await request.json(); 

        // Return the response
        return response;

    } catch(error) {
        console.log('Bad request');
        return error.response;
    }
}

export default performApiCall;