<template>
    <div class="row users">
        <div class="col" v-for="user in users">
            <user-card
                    :user="user"
            ></user-card>
        </div>
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
                        this.users = response.data.users
                    })
            }
        }
    }
</script>