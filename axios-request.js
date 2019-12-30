// Vue Axios wrapper
const http = {
    request: function(url, params, callback, method = 'get'){
        if(method.toLowerCase() === 'get'){
            params = {
                params: params
            }
        }
        
        axios[method](url, params).then( function(response){
            callback(response);
        });
    }
};