<template>
    <div class="user-card d-flex">
            <div>
                <img :src="user.avatar" alt="">
            </div>
            <div class="user-info-box">
                <div class="user-card-text">
                    <div>
                        {{user.name}}
                    </div>
                    <div>
                        <a :href="'mailto:' + user.email">{{user.email}}</a>
                    </div>
                </div>
                <div class="user-buttons">
                    <button class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ]
    }
</script>