<template>
    <div>
        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-secondary">Random</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#userFormModal"
                    @click="userCreateForm"
                >Create</button>
            </div>
            <div class="col-md-3">
                <form class="form-inline">
                    <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-7">
                <div class="table-responsive d-flex justify-content-center">
                    <pagination :data="users" :show-disabled="true" @pagination-change-page="loadUsers"></pagination>
                </div>
            </div>
        </div>
        <div class="row users">
            <div class="col" v-for="user in users.data">
                <user-card
                        :user="user"
                ></user-card>
            </div>
        </div>
        <user-form
            :ifCreating="ifCreating"
        ></user-form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                users: {},
                page: 1,
                ifCreating: false
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


            selectUser() {
                this.user = this.$root.$emit('selectUser')
            },

            userCreateForm() {
                this.ifCreating = !this.ifCreating;
            }
        }
    }
</script>