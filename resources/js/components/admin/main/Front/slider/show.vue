<template>
    <div class="container card pb-5">
        <h1 class="card-title">create Slider</h1>
        <router-link class="btn btn-success" to="/admin/add-slider">Add Slider</router-link>
        <div class="container mt-3">
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
                    <td><img :src="'../'+data.image" alt="" width="50"></td>
                    <td>
                        <button class=" btn btn-success" @click="Edit(data.id)">
                            Edit
                        </button>
                        <button class=" btn btn-danger" @click="Delete(data.id)">
                          Delete
                        </button>
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
        axios.get('/api/slider', {
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
            router.push('/admin/edit-slider/' + index)
        },
        Delete(index) {
            axios.delete('/api/slider/' + index, {
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
    