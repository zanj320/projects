<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { api } from '../boot/axios.js'

export default {
    name: "Register",
    setup() {
        //
    },
    data() {
        return {
            name: '',
            surname: '',
            email: '',
            password: '',
            confirm_password: '',
            errorMessage: ''
        };
    },
    mounted () {
        if (localStorage.getItem('token') != null || localStorage.getItem('user') != null) {
            this.$router.push('/');
        }
    },
    methods: {
        async sendRegisterData() {
            if (this.password != this.confirm_password) {
                this.errorMessage = 'Passwords are not matching.'
                return;
            }

            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.post('/register', {
                    name: this.name,
                    surname: this.surname,
                    email: this.email,
                    password: this.password,
                    confirm_password: this.confirm_password
                })
                
                localStorage.setItem('token', reply.data.token)
                localStorage.setItem('user', JSON.stringify(reply.data.user))

                this.errorMessage = ''
                this.$router.push('/')
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        },
        goToHome() {
            this.$router.push("/");
        },
        goToLogin() {
            this.$router.push("/login");
        }
    }
}

</script>

<template>
    <div class="container bg-light rounded" style="width: 500px">
        <h2 class="mb-3">Register</h2>
        <div class="input text-start">
            <label for="name">Name</label>
            <input
                v-model="name"
                class="form-control"
                type="text"
                name="name"
                placeholder="name"
                minlength="3"
                pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$"
            />
        </div>
        <div class="input text-start">
            <label for="surname">Surname</label>
            <input
                v-model="surname"
                class="form-control"
                type="text"
                name="surname"
                placeholder="surname"
                minlength="3"
                pattern="^[a-zA-ZšđčćžŠĐČĆŽ]+$"
            />
        </div>
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
                minlength="6"
            />
        </div>
        <div class="input text-start">
            <label for="confirm_password" >Confirm password</label>
            <input
                v-model="confirm_password"
                class="form-control"
                type="password"
                name="confirm_password"
                placeholder="password123"
                minlength="6"
            />
        </div>
        <div class="alternative-option mt-4">
            Already have an account? <a v-on:click="goToLogin" style="cursor: pointer"><u>Login</u></a>
        </div>
        <button class="mt-4 btn btn-primary" v-on:click="sendRegisterData">
            Register
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