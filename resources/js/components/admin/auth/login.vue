<template>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>

                                    </div>
                                    <form class="user" method="post" @submit.prevent="login">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" v-model="form.email"
                                                autocomplete="current-password" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                            <small v-if="error" class="text-danger">{{ error }}</small>
                                            <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>

                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" v-model="form.password"
                                                autocomplete="current-password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>

                                    </form>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>
<script>

import { useStore } from 'vuex'
import adminrouter from '../../../adminrouter'
import adminstore from '../../../adminstore'

export default {
    setup() {
        //const adminstore = useStore()
    },
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            error: '',
            errors: {}
        }
    },
    created() {
        this.checkExpiration()
    },
    methods: {
        async login() {
            await axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/login', this.form).then((res) => {
                    console.log(res)
                    if (res.data.status == 1) {
                        adminstore.dispatch('setAdminUser', res.data.username)
                        adminstore.dispatch('setAdminToken', res.data.token)
                        toast.fire({
                            icon: "success",
                            title: res.data.message,
                        });
                        window.location = '/admin'
                        //adminrouter.push('/admin/')
                    } else {
                        this.error = res.data.message
                    }
                }).catch((error) => (this.errors = error.response.data.errors))
            });
        },

        checkExpiration() {
            const expireAt = localStorage.getItem('expire_at');
            console.log(expireAt);
            if (expireAt) {
                const now = new Date().getTime();
                console.log(now);
                console.log(now - expireAt)
                if (now > expireAt) {
                    localStorage.clear();

                }
            } else {
                localStorage.clear();

            }
        }
    }
}
</script>