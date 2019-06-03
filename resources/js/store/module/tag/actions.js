import { getTag } from '@/service/tag'

export default {
    getTag({commit}, payload) {
        return new Promise((resolve, reject) => {
            getTag(payload.page).then(res => {
                commit('getTag', res)
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
}
