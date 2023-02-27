<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { api } from '../boot/axios.js'

export default {
    name: "Login",
    setup() {
        //
    },
    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        };
    },
    mounted () {
        if (localStorage.getItem('token') != null || localStorage.getItem('user') != null) {
            this.$router.push('/');
        }
    },
    methods: {
        async sendLoginData() {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.post('/login', {
                    email: this.email,
                    password: this.password,
                })
                
                localStorage.setItem('token', reply.data.token)
                localStorage.setItem('user', JSON.stringify(reply.data.user))

                //this.userStore.token = reply.data.token
                //this.userStore.user = reply.data.user

                this.errorMessage = ''
                this.$router.push('/')
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        },
        goToHome() {
            this.$router.push("/");
        },
        goToRegister() {
            this.$router.push("/register");
        },
    },
}

</script>

<template>
    <div class="container bg-light rounded" style="width: 500px">
      <h2 class="mb-3">Login</h2>
      <div class="input text-start">
        <label for="email">Email address</label>
        <input
            v-model="email"
            class="form-control"
            type="email"
            name="email"
            placeholder="email@adress.com"
        />
      </div>
      <div class="input text-start">
        <label for="password" >Password</label>
        <input
            v-model="password"
            class="form-control"
            type="password"
            name="password"
            placeholder="password123"
        />
      </div>
      <div class="alternative-option mt-4">
        You don't have an account? <a v-on:click="goToRegister" style="cursor: pointer"><u>Register</u></a>
      </div>
      <button class="mt-4 btn btn-primary" v-on:click="sendLoginData">
        Login
      </button>
    <br/>
    <br/>
    <div v-if="errorMessage.length > 0"
      class="alert alert-danger"
      role="alert"
      id="alert_1"
    >
      {{ errorMessage }}
    </div>
  </div>
</template>

<style scoped>

</style>