<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { api } from '../boot/axios.js'
import moment from 'moment';

export default {
    name: "MyComments",
    setup() {
        let comments = ref([]);

        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));

        onMounted(() => {
            api
            .get('/getUserComments')
            .then((res) => {
                comments.value = res.data.comments;
            })
            .catch((error) => {
                console.error(error.message);
            });
        });
        
        return {
            comments,
            token,
            user
        };
    },
    data() {
        return {
            id_comment: '',
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
        async removeSingleComment(id_comment) {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.delete('/removeSingleComment', {
                    params: {
                        id_comment: id_comment,
                        page: 'user'
                    }
                })
                
                this.message = reply.data.message
                this.comments = reply.data.comments
                this.errorMessage = ''
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        },
        async removeAllComments() {
            if (!confirm("Are you sure you want to delete all comments?")) {
                return;
            }

            if (this.comments.length <= 0) {
                this.errorMessage = "User doesn't have any comments!";
                return;
            }

            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.delete('/removeAllComments')
                
                this.message = reply.data.message
                this.comments = reply.data.comments
                this.errorMessage = ''
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        },
        getFormattedDate(date) {
            return moment(date).format("DD.MM.YYYY")
        },
        getFormattedTime(date) {
            return moment(date).format("HH:mm")
        }
    }
}

</script>

<template>
    <div class="container" style="width: 550px">
        <h1>My comments</h1>
        <div>
            <button v-on:click="goToHome">Home</button>
        </div>
        <br/>
        <div v-for="comment in comments" :key="comment.id_comment" class="bg-light p-3 m-2 text-start position-relative">
            <div> {{ comment.data }}</div>
            <br/>
            <div>
                <div class="position-absolute pb-2 bottom-0">
                    <u>
                    {{ getFormattedDate(comment.created_at) }} at {{ getFormattedTime(comment.created_at) }}
                    </u>
                </div>
                <div style="position: absolute; right: 10px;">
                    <button v-on:click="removeSingleComment(comment.id_comment)" class="btn btn-danger p-0">Delete</button>
                </div>
            </div>
            <br/>
        </div>
        <br/>
        <div v-if="comments.length>0">
            <button v-on:click="removeAllComments" class="btn btn-danger">Remove all comments</button>
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
</template>

<style scoped>

</style>