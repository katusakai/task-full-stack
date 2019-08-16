<template>
    <div>
        <div class="users-menu-display-type">
            <div class="users-menu-mb">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-secondary mr-sm-1"
                            @click="createRandomUser"
                    >Random</button>
                    <button class="btn btn-warning mr-sm-1" data-toggle="modal" data-target="#userFormModal"
                            @click="userCreateForm"
                    >Create</button>
                </div>
            </div>
            <div class="users-menu-display-type">
                <input class="form-control mr-sm-1 users-menu-mb" type="search" placeholder="Search" aria-label="Search"
                       v-model="searchInput"
                       @keyup="search"
                       @blur="search"

                >
                <pagination
                        :data="users"
                        :show-disabled="true"
                        :limit="1"
                        @pagination-change-page="loadUsers">
                </pagination>
            </div>
        </div>
        <div class="row users">
            <div class="col" v-for="user in users.data">
                <user-card
                        :user="user"
                ></user-card>
            </div>
        </div>
        <user-form></user-form>
    </div>
</template>

<script>
    import {eventBus} from "../../app.js";
    export default {
        data: function() {
            return {
                users: {},
                page: 1,
                ifCreating: false,
                randomUser: {},
                searchInput: ''
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
                axios.get('/users/' + '%' + this.searchInput + '?page=' + page)
                    .then(response => {
                        this.users = response.data.users;
                        this.page = page;
                    })
            },

            selectUser() {
                this.user = this.$root.$emit('selectUser')
            },

            userCreateForm() {
                eventBus.$emit('ifCreating')
            },

            createRandomUser() {
                if (confirm('Do you want to create a random user?')) {
                    axios.post('/users/random');
                    this.loadUsers(this.page);
                    alert('Random user was created');
                }
            },

            search() {
                this.loadUsers();
            }
        }
    }
</script>