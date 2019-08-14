<template>
    <div>
        <div class="table-responsive d-flex justify-content-center">
            <pagination :data="users" :show-disabled="true" @pagination-change-page="loadUsers"></pagination>
        </div>
        <div class="row users">
            <div class="col" v-for="user in users.data">
                <user-card
                        :user="user"
                ></user-card>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                users: {},
                page: 1
            }
        },

        mounted() {
            this.loadUsers();
            this.$root.$on('loadUsers', () => {
                this.loadUsers(this.page);
            });
        },

        methods: {
            loadUsers(page) {
                axios.get('/users' + '?page=' + page)
                    .then(response => {
                        this.users = response.data.users;
                        this.page = page;
                    })
            },
        }
    }
</script>