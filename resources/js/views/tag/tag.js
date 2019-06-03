export default {
    name: 'tag',
    components: {},
    props: [],
    data() {
        return {
            page: 1,
            fields: [
                { key: 'id', label: '#'},
                { key: 'name', label: 'name'},
                { key: 'description', label: 'Description'},
                { key: 'created_at', label: 'Created at'},
                { key: 'action', label: 'action' }
            ]
        }
    },
    computed: {
        items() {
            return this.$store.getters['Tag/getTag']
        },
        total() {
            return this.$store.getters['Tag/getTotal']
        },
        last_page() {
            return this.$store.getters['Tag/getLastPage']
        }
    },
    mounted() {
        this.$store.dispatch('Tag/getTag', {page: this.page}).then(res => {

        }).catch(res => {

        })
    },
    methods: {
        changePage (page) {
            this.page = page
            this.$store.dispatch('Tag/getTag', {page: this.page}).then(res => {
                window.scrollTo(0,0)
            }).catch(res => {
    
            })
        }
    }
}
