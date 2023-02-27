import { createRouter, createWebHashHistory, createWebHistory } from "vue-router";
import Index from "../views/Index.vue";
import Register from "../views/Register.vue";
import Login from "../views/Login.vue";
import PostComment from "../views/PostComment.vue";
import MyComments from "../views/MyComments.vue";
import EditMyData from "../views/EditMyData.vue";

const routes = [
    {
        path: '/',
        name: 'Index',
        component: Index
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/postComment',
        name: 'PostComment',
        component: PostComment
    },
    {
        path: '/myComments',
        name: 'MyComments',
        component: MyComments
    },
    {
        path: '/editMyData',
        name: 'EditMyData',
        component: EditMyData
    },
];

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router;