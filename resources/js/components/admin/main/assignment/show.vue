<template>
         <h6 class="m-0 font-weight-bold text-primary p-3">show assignment</h6>
    <div class="container card table-responsive">
        <table class="table">
            <thead class="bg-success text-white">
                <th>S.N</th>
                <th>Subjects</th>
                <th>Faculty</th>
                <th>Section</th>
                <th>Semester/Yrs</th>
                <th>Teacher</th>
                <th>Topic</th>
                <th>Deadline</th>
                <th>Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td>{{+ + index }}</td>
                    <td>{{ data.subject }} </td>
                    <td>{{ data.faculty.faculty_name }}</td>
                    <td>{{ data.section.section_name}}</td>
                    <td>{{ data.semester.semester_years}}</td>
                    <td>{{ data.user.name }}</td>
                    <td>{{ data.topic }}</td>
                    <td>{{ data.deadline }}</td>
                    <td>{{ data.created_at.split('T')[0] }}</td>
                    <td>

                        <button class=" btn btn-success" @click="EditAssignment(data.id)">
                            Edit
                        </button>
                        <button class=" btn btn-success" @click="ViewAssignment(data.id)">
                            view
                        </button>
                        <button class="btn btn-danger" @click="DeleteAssignment(data.id)">
                            Delete
                        </button>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import router from '../../../../adminrouter';
import store from '../../../../adminstore';

export default {
    data() {
        return {
            datas: []
        }
    },
    created() {
        // if (!User.loggedIn()) {
        //     router.push("/admin/login")
        // }
        axios.get("/api/assignment", {
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + store.getters.getAdminToken,
            },
        }).then((res) => {
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
        ViewAssignment(index) {
            router.push('/admin/view-assignment/' + index);

        },
        EditAssignment(index) {
            router.push('/admin/edit-assignment/' + index);

        },
        DeleteAssignment(index) {
            axios.delete("/api/assignment/" + index, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + store.getters.getAdminToken,
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
