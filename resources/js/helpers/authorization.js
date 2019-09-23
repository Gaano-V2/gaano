export function initialize(store, router) {

    router.beforeEach((to, from, next) => {

        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.current_user;

        //console.log(to.meta.permisson);

        if (requiresAuth && !currentUser) {

            next('/');

        } else {

            next();

        }

        switch(to.meta.permisson) {

            case 'user':

                if (requiresAuth && currentUser.status === 2 && to.meta.permisson === 'user') {

                    next('/admin');

                } else {

                    next();

                }

                break;

            case 'admin':

                if (requiresAuth && currentUser.status === 1 && to.meta.permisson === 'admin') {

                    next('/home');

                } else {

                    next();

                }

                break;

            default:

                break;

        }

    });

    axios.interceptors.response.use(null, (error) => {

        if (error.response.status == 401) {

            store.commit('failsafe');

            router.push('/');

        }

        return Promise.reject(error);

    });

    //axios.defaults.headers.common["Authorization"] = `Bearer ${store.getters.currentUser.token}`;

    if (store.getters.current_user) {
          setAuthorization(store.getters.current_user);
    }

}

export function setAuthorization(user) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${user.token}`
}
