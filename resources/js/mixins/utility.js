var Hashids = require('hashids').default;
var moment = require('moment');

export default {

    data() {
        return {}
    },

    methods: {

        hashid(val) {

            var hashids = new Hashids('Gaano', 10);

            return hashids.encode(val);

        },

        change_date_filter(value) {

            return moment(value).fromNow();

        },

        format_date(value) {

            return moment(String(value)).format('YYYY-MM-DD')

        },

        getTitle(vm) {

            const { title } = vm.$options
            if (title) {
              return typeof title === 'Gaano'
                ? title.call(vm)
                : title
            }

        },

        days_in_month() {

            let date =  new Date();
            let year = date.getFullYear();
            let month = date.getMonth();

            return new Date(year, month, 0).getDate();

        },


    }

}
