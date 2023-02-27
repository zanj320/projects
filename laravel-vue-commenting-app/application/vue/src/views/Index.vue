<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
//import { useUserStore } from "../stores/UserStore.js";
import { api } from '../boot/axios.js';
import moment from 'moment';

export default {
    name: "Index",
    setup() {
        let comments = ref([]);
//        const userStore = useUserStore();

        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));

        onMounted(() => {
            api
            .post('/getAllComments', {
                offset: 1
            })
            .then((res) => {
                comments.value = res.data.comments
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
            end: false,
            offset: 1,
            errorMessage: ''
        };
    },
    methods: {
        goToRegister() {
            this.$router.push("/register");
        },
        goToLogin() {
            this.$router.push("/login");
        },
        goToPostComment() {
            this.$router.push("/postComment");
        },
        goToMyComments() {
            this.$router.push("/myComments");
        },
        goToEditMyData() {
            this.$router.push("/editMyData");
        },
        async logOut() {
            await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')

            const reply = await api.delete('/logout')
            .catch((error) => {
                console.log(error.message);
            });
            
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            this.$router.go(0);
        },
        async removeSingleComment(id_comment) {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.delete('/removeSingleComment', {
                    params: {
                        id_comment: id_comment,
                        offset: this.offset,
                        page: 'index'
                    }
                })
                
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
        },
        async loadMoreComments() {
            this.offset++;
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.post('/getAllComments', {
                    offset: this.offset
                })
                
                this.comments = reply.data.comments
                this.end = reply.data.end
                this.errorMessage = ''
                this.message = ''
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        }
    }
}

</script>

<template>
    <div class="container" style="width: 550px">
        <h1>Index page</h1>
        <div v-if="token == null">
            <button v-on:click="goToRegister">Register</button> 
            <button v-on:click="goToLogin">Login</button>
        </div>
        <div v-if="token != null">
            <p>Logiran uporabnik: {{ user.name }} {{ user.surname }}</p>
            <button v-on:click="logOut">Logout</button>
            <button v-on:click="goToPostComment">Post comment</button>
            <button v-on:click="goToMyComments">My comments</button>
            <button v-on:click="goToEditMyData">Edit my data</button>
        </div>
        <br/>
        <div v-for="comment in comments" :key="comment.id_comment" class="bg-light p-3 m-2 text-start position-relative">
            <div> {{ comment.data }}</div>
            <br/>
            <div>
                <div class="position-absolute pb-2 bottom-0">
                    <u>{{ comment.name }} {{ comment.surname }},
                    {{ getFormattedDate(comment.created_at) }} at {{ getFormattedTime(comment.created_at) }}
                    </u>
                </div>
                <div style="position: absolute; right: 10px;">
                    <button v-if="token != null && comment.id_user==user.id_user" v-on:click="removeSingleComment(comment.id_comment)" class="btn btn-danger p-0">Delete</button>
                </div>
            </div>
            <br/>
        </div>
        <div v-if="!end && comments.length>=4">
            <button v-on:click="loadMoreComments" class="btn btn-primary">load more</button>
        </div>
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