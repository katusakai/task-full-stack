<template>
    <!-- Modal -->
    <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{formVisualData.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit="formSubmit" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="form-name" class="col-sm-3 col-form-label">Name:</label>
                            <div class="col-sm-9">
                                <input name="name" class="form-control" id="form-name" type="text" required max="50"
                                       v-model="user.name"
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="form-email" class="col-sm-3 col-form-label">Email:</label>
                            <div class="col-sm-9">
                                <input name="email" class="form-control" id="form-email" type="email" required max="50"
                                       v-model="user.email"
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="form-avatar" class="col-sm-3 col-form-label">Avatar:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="avatar" type="file" class="custom-file-input" id="form-avatar"
                                               v-on:change="onAvatarChange"
                                        >
                                        <label class="custom-file-label" for="form-avatar">{{formVisualData.fileName ? formVisualData.fileName : 'Choose file'}}</label>
                                    </div>
                                </div>
                                <div v-if="user.avatar" class="pt-2">
                                    <img :src="user.avatar" class="img-responsive" height="128" width="128">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success">{{formVisualData.buttonText}}</button>
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
    import {eventBus} from "../../app.js";
    export default {
        props: [
        ],

        data() {
            return {
                user: {},
                message: null,
                ifUploadingAvatar: false,
                formMethod: '',
                formVisualData: {}
            };
        },

        created() {
            eventBus.$on('selectUser', (user) => {
                this.user = user;
                this.message = null;
                this.ifUploadingAvatar = false;
                this.formMethod = 'update';
                this.formVisualData.title = 'Edit user';
                this.formVisualData.buttonText = 'Update';
            });

            eventBus.$on('ifCreating', () => {
                this.user = {avatar: ''};
                this.message = null;
                this.ifUploadingAvatar = false;
                this.formMethod = 'create'
                this.formVisualData.title = 'Create user';
                this.formVisualData.buttonText = 'Create';
            });
        },

        methods: {
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                switch (this.formMethod) {
                    case "create":
                        this.createUser(currentObj);
                        break;
                    case "update":
                        if(this.ifUploadingAvatar) {
                            this.updateWithAvatar(currentObj);
                        } else {
                            this.updateWithoutAvatar(currentObj);
                        }
                        break;
                }

                this.updateUser();
            },

            updateUser() {
                this.$root.$emit('loadUsers')
            },

            onAvatarChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createAvatar(files[0]);

                this.changeFileInputLabel();
            },

            createAvatar(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.user.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
                this.ifUploadingAvatar = !this.ifUploadingAvatar;
            },

            updateWithAvatar(currentObj) {
                axios.put('/users/' + this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                    avatar: this.user.avatar
                })
                    .then(function (response) {
                        currentObj.message = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.message = error;
                    });
            },

            updateWithoutAvatar(currentObj) {
                axios.put('/users/' + this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                })
                    .then(function (response) {
                        currentObj.message = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.message = error;
                    });
            },

            createUser(currentObj) {
                axios.post('/users/', {
                    name: this.user.name,
                    email: this.user.email,
                    avatar: this.user.avatar
                })
                    .then(function (response) {
                        currentObj.message = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.message = error;
                    });
            },

            changeFileInputLabel() {
                let fileInput = document.getElementById('form-avatar');
                let fileName = fileInput.files[0].name;
                if(fileName.length > 18) {
                    fileName = fileName.slice(fileName.length - 18);
                }
                this.formVisualData.fileName = fileName;
            }
        }
    }
</script>