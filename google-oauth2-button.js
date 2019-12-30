var oauthServerPath = 'oauth.php';

Vue.component('google-login',{
    mixins: [http],
    data: function() {
        return {
            authed: false,
            userProfile: {}
        }
    },
    methods: {
        getCode: function(){
            var url = new URL( window.location.href );
            var code = ( url.searchParams.get("code") );
            
            http.request( oauthServerPath, { code }, ( response ) => {
                if( response.data.user_profile ) {
                    this.authed = true;
                    this.userProfile = response.data.user_profile;
                    this.emitProfile();
                }
            }, 'get' );
        },
        googleAuth: function() {
            http.request( oauthServerPath, null, ( response ) => {
                this.authUrl = response.data.authUrl;
                window.location.replace( this.authUrl );                            
            }, 'get' );
        },
        logout: function() {
            if(confirm("Are you sure you want to log out?")){
                http.request( oauthServerPath, { logout: true }, ( response ) => {
                    location.reload();
                }, 'post' );
            }
        },
        emitProfile: function() {
            this.$emit( 'profile', this.profile );
        }
    },
    mounted: function(){
        this.getCode();
    },
    template: `
    <div>
        <img src="google.png" style="cursor: pointer;" @click="googleAuth()" v-if="!authed">
        <div v-else>
            <div v-if="userProfile">
                <div>
                    <img :src="userProfile.picture" v-if="userProfile.picture">
                </div>
                <div>
                    <b>{{userProfile.name}}</b><br>
                    <a href="#" @click="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    `
});