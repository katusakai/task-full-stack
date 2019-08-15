<template>
    <!-- Modal -->
    <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit="formSubmit" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="form-name" class="col-sm-3 col-form-label">Name:</label>
                            <div class="col-sm-9">
                                <input name="name" class="form-control" id="form-name" type="text" required
                                       v-model="name"
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="form-email" class="col-sm-3 col-form-label">Email:</label>
                            <div class="col-sm-9">
                                <input name="email" class="form-control" id="form-email" type="text" required
                                       v-model="email"
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="form-avatar" class="col-sm-3 col-form-label">Avatar:</label>
                            <div class="col-sm-9">
                                <input name="avatar" id="form-avatar" type="file"
                                >
                            </div>
                        </div>
                        <button class="btn btn-success">Update</button>
                    </form>
                    <div v-if="message">
                        <pre>
                        {{message}}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props: [
        //     'user'
        // ],

        data() {
            return {
                user: {},
                name: '',
                email: '',
                avatar: '',
                message: null,
                fromsister: ''
            };
        },

        methods: {
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.put('/user/' + this.user.id, {
                    name: this.name,
                    email: this.email,
                    // avatar: this.avatar
                })
                    .then(function () {
                        currentObj.message = "Profile was updated";
                    })
                    .catch(function (error) {
                        currentObj.message = error;
                    });
                this.updateUser();
            },

            updateUser() {
                this.$root.$emit('loadUsers')
            },
        }

    }
</script>