





export default
    {
        getUser(){
            axios.post('/api/user', {
                token: localStorage.getItem('jwt'),
            }).then((request)=>{
                return request.data.user;
            }).catch( (error)=>{
                console.log(error);
                localStorage.removeItem('jwt')
            } );
        },


    };
