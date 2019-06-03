import { HTTP } from '@/base-axios'

export function getTag(page = 1) {
    return HTTP.get('tags', {
        params: {
            page
        }
    })
}
