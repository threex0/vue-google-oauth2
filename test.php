<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>

        <script src="axios-request.js"></script>
        <script src="google-oauth2-button.js"></script>
    </head>
    <body>
        <div id="app">
            <google-login></google-login>
        </div>
    </body>
    <script>
        new Vue({
            el: '#app'
        })
    </script>
</html>