<template>
    <div class="user-card">
            <div>
                <img class="user-image" :src="user.avatar" alt="">
            </div>
            <div class="user-info-box">
                <div class="user-card-text">
                    <div>
                        <strong>
                            Name:
                        </strong>
                    </div>
                    <div>
                        {{user.name}}
                    </div>
                    <div>
                        <strong>
                            Email:
                        </strong>
                    </div>
                    <div>
                        <a :href="'mailto:' + user.email">{{user.email}}</a>
                    </div>
                    <div>
                        <strong>
                            Member since:
                        </strong>
                    </div>
                    <div data-toggle="tooltip" :title=user.created_at>
                        {{user.created_at | date}}
                    </div>
                </div>
                <div class="user-buttons">
                    <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#userFormModal"
                        @click="selectUser()"
                    >Update</button>
                    <button class="btn btn-sm btn-danger"
                        @click="deleteUser(user.id)"
                    >Delete</button>
                </div>
            </div>
    </div>
</template>

<script>
    import {eventBus} from "../../app.js";
    export default {
        props: [
            'user'
        ],
        filters: {
            date: function (value) {
                let date = new Date(value);
                return date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate();
            }
        },

        methods: {

            selectUser() {
                eventBus.$emit('selectUser', this.user)
            },

            deleteUser(user) {
                if (confirm('are you sure?')) {
                    axios.delete('/user/' + user)
                        .then(response => {
                            if(response.status === 200) {
                                this.updateUsers()
                            }
                        })
                }
            },

            updateUsers() {
                this.$root.$emit('loadUsers')
            }
        }
    }
</script>