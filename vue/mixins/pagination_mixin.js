export const pagination_mixin = {
    data() {
        return {
            pagination: {
                total: 0,
                count: 0,
                per_page: 0,
                current_page: 1,
                total_pages: 0
            },
        }
    }
}