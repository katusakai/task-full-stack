<template>
    <div>
        {{users}}
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                users: {}
            }
        },

        mounted() {
            this.loadUsers();
        },

        methods: {
            loadUsers() {
                axios.get('/users')
                    .then(response => {
                        this.users = response.data
                    })
            }
        }
    }
</script>