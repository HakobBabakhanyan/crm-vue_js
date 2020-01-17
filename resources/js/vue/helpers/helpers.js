export default {
    getUser() {
        axios.post('/api/user', {
            token: localStorage.getItem('jwt'),
        }).then((request) => {
            return request.data.user;
        }).catch((error) => {
            console.log(error);
            localStorage.removeItem('jwt')
        });
    },
    nextFactory(context, middleware, index) {
        const subsequentMiddleware = middleware[index];
        // If no subsequent Middleware exists,
        // the default `next()` callback is returned.
        if (!subsequentMiddleware) return context.next;

        return (...parameters) => {
            // Run the default Vue Router `next()` callback first.
            context.next(...parameters);
            // Than run the subsequent Middleware with a new
            // `nextMiddleware()` callback.
            const nextMiddleware = this.nextFactory(context, middleware, index + 1);
            subsequentMiddleware({...context, next: nextMiddleware});
        };
    }

};
