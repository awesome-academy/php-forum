export default {
    name: 'user',
    components: {},
    props: [],
    data() {
        return {
            page: 0,
            fields: [
                { key: 'id', label: '#'},
                { key: 'full_name', label: 'Full name'},
                { key: 'email', label: 'Email'},
                { key: 'provider', label: 'Provider'},
                { key: 'avatar', label: 'Avatar' },
                { key: 'active', label: 'Active' }
            ],
        }
    },
    computed: {
        items() {
            return this.$store.getters['User/getUser']
        },
        total() {
            return this.$store.getters['User/getTotal']
        },
        last_page() {
            return this.$store.getters['User/getLastPage']
        }
    },
    mounted() {
        this.$store.dispatch('User/getUser', { page : this.page }).then(res => {

        }).catch(res => {
            
        })
    },
    methods: {
        active (user_id) {
            this.$store.dispatch('User/activeUser', { user_id }).then(res => {

            }).catch(res => {
                
            })
        },

        changePage (page) {
            this.page = page
            this.$store.dispatch('User/getUser', { page : this.page }).then(res => {
                window.scrollTo(0,0)
            }).catch(res => {
                
            })
        },

        selectRow (items) {

        }
    }
}
