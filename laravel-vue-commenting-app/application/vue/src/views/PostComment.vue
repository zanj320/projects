<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { api } from '../boot/axios.js'

export default {
    name: "PostComment",
    setup() {
        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));
        
        return {
            token,
            user
        };
    },
    data() {
        return {
            data: '',
            message: '',
            errorMessage: ''
        };
    },
    mounted () {
        if (localStorage.getItem('token') === null || localStorage.getItem('user') === null) {
            this.$router.push('/');
        }
    },
    methods: {
        goToHome() {
            this.$router.push("/");
        },
        async sendCommentData() {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.post('/postComment', {
                    data: this.data,
                })
                
                this.errorMessage = ''
                this.message = reply.data.message
                this.$router.push('/')
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        }
    }
}

</script>

<template>
    <div class="container bg-light rounded" style="width: 500px">
        <h1>Post a comment</h1>
        <div>
            <button v-on:click="goToHome">Home</button>
        </div>
        <br/>
        <div>
            <div>
                <textarea
                    v-model="data"
                    type="text"
                    placeholder="Write a comment..."
                    class="form-control"
                    style="height: 250px; width: 100%"
                    maxlength="500"
                />
            </div>
            <br/>
            <div>
                <button v-on:click="sendCommentData" class="btn btn-primary">Post a comment</button>
            </div>
            <br/>
            <div v-if="errorMessage.length > 0"
                class="alert alert-danger"
                role="alert"
                id="alert_1"
                >
                {{ errorMessage }}
                </div>
                <div v-if="message.length > 0"
                class="alert alert-success"
                role="alert"
                id="alert_2"
                >
                {{ message }}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>