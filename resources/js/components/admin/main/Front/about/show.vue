<template>
    <div class="container card pb-5">
        <h1 class="card-title">create About</h1>
        <router-link class="btn btn-success" to="/admin/add-about">Add About</router-link>
        <div class="container">
            <table class="table">
                <tr>
                    <th>S.N</th>
                    <th>Heading</th>
                    <th>SubHeading</th>
                    <th>Desctiption</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <tr v-for="(data, index) in datas" :key="index">
                    <td>{{ ++index }}</td>
                    <td>{{ data.heading }}</td>
                    <td>{{ data.subheading }}</td>
                    <td>{{ data.description }}</td>
                    <td><img :src="'../' + data.image" alt="" width="50"></td>
                    <td>
                        <span class="  btn btn-success" @click="Edit(data.id)">
                            Edit
                        </span>
                        <span class=" btn btn-danger" @click="Delete(data.id)">
                            Delete
                        </span>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios';
import router from '../../../../../adminrouter';
import store from '../../../../../adminstore';

export default {
    data() {
        return {
            datas: [],
        }
    },
    created() {
        // if (!User.loggedIn()) {
        //     router.push("/admin/login")
        // }
        axios.get('/api/about', {
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " +store.getters.getAdminToken,
            },
        }).then((res) => {
            console.log(res)
            this.datas = res.data
        }).catch((error) => {
            router.push('/admin/login');
            localStorage.clear()
            toast.fire({
                icon: "error",
                title: error.response.data.message
            })
        })
    },
    methods: {
        Edit(index) {
            router.push('/admin/edit-about/' + index)
        },
        Delete(index) {
            axios.delete('/api/about/' + index, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " +store.getters.getAdminToken,
                },
            }).then((res) => {
                toast.fire({
                    icon: "succcess",
                    title: res.data.status
                })
                this.datas = this.datas.filter(data => {
                    return data.id != index
                })

            })
        }
    }
}
</script>