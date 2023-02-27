<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { api } from '../boot/axios.js'

export default {
    name: "EditMyData",
    setup() {
        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));


        return {
            user,
            token
        };
    },
    data() {
        return {
            name: '',
            surname: '',
            password: '',
            new_password: '',
            old_password: '',
            errorMessage: '',
            message: ''
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
        async sendEditData() {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.patch('/editUser', {
                    name: this.user.name,
                    surname: this.user.surname,
                    new_password: this.new_password,
                    old_password: this.old_password
                })
                
                localStorage.setItem('user', JSON.stringify(reply.data.user))

                this.message = reply.data.message
                this.errorMessage = ''
                this.new_password = ''
                this.old_password = ''
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        },
        async deleteUser() {
            if (!confirm("Are you sure you want to delete this user?")) {
                return;
            }

            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
                const reply = await api.delete('/deleteUser', {
                    params: {
                        old_password: this.old_password
                    }
                })
                
                if (reply.data.same) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');

                    this.message = reply.data.message
                    this.errorMessage = ''

                    this.$router.push('/')
                } else {
                    this.errorMessage = 'Invalid password.'
                }
            } catch (errors) {
                this.errorMessage = errors.response.data.message
            }
        }
    }
}

</script>

<template>
    <div class="container bg-light rounded" style="width: 500px">
      <h2 class="mb-3">Edit data</h2>
      <div>
            <button v-on:click="goToHome">Home</button>
      </div>
      <div class="input text-start">
            <label for="name">Name</label>
            <input
                v-model="user.name"
                class="form-control"
                type="text"
                name="name"
                placeholder="name"
            />
        </div>
        <div class="input text-start">
            <label for="surname">Surname</label>
            <input
                v-model="user.surname"
                class="form-control"
                type="text"
                name="surname"
                placeholder="surname"
            />
        </div>
      <div class="input text-start">
        <label for="email">Email address</label>
        <input
            v-model="user.email"
            class="form-control"
            type="email"
            name="email"
            placeholder="email@adress.com"
            disabled
        />
      </div>
      <div class="input text-start">
        <label for="new_password" >New password (can be empty)</label>
        <input
            v-model="new_password"
            class="form-control"
            type="password"
            name="new_password"
            placeholder="new password"
        />
      </div>
      <div class="input text-start">
        <label for="old_password" >Confirm changes with old password</label>
        <input
            v-model="old_password"
            class="form-control"
            type="password"
            name="old_password"
            placeholder="old password"
            required
        />
      </div>
      <button class="mt-4 btn btn-primary" v-on:click="sendEditData">
        Apply
      </button>
      <button class="mt-4 btn btn-danger" v-on:click="deleteUser">
        Delete user
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