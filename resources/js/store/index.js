import Vue from 'vue'
import Vuex from 'vuex'
import Profile from '@/store/module/profile'
import User from '@/store/module/user'
import Tag from '@/store/module/tag'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        Profile,
        User,
        Tag
    }
})
