<template>
  <div class="card-body table-responsive" style="background: white;">
    <h5 class="card-title">All Staffs Details</h5>

    <DataTable 
                 :data="staffs"
                :columns="columns"

                        >
   
      <thead>
        <tr>
          <th scope="col">S.N</th>
         
          <th scope="col">Name</th>
          <th scope="col">Address</th>
          <th scope="col">Phone</th>
          <th scope="col">Email</th>
          <th scope="col">Gender</th>
          <th scope="col">Category</th>
          <th scope="col">Blood_Group</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>

        </tr>
      </thead>
     </DataTable>


  </div>
</template>
<script>
import router from '../../../../adminrouter';
import store from '../../../../adminstore';

export default {
  data() {
    return {
      staffs: [],
      columns: [
                    { data: 'id' },
                   
                    {data:'name'},
                    {data:'address'},
                    {data:'contact'},
                    {data:'email'},
                   
                  
               
                    {data:'gender'},
                    {data:'staff_category'},
                    {data:'bloodgroup'},
                    {
                        data: 'id',
                        render: function (data) {
                        return  `<button data-id="${data}" class="btn btn-info" id="edit">Edit</button>`;
                        }
                    },
                    {
                        data: 'id',
                        render: function (data) {
                        return `<button data-id="${data}" class="btn btn-danger" id="delete">Delete</button>`;
                        }
                    },
                    
    ]
    };
  },
  created() {
    // if (!User.loggedIn()) {
    //   router.push("/admin/login")
    // }
    axios.get("/api/staffs", {
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " +store.getters.getAdminToken,
      },
    }).then((res) => {
      console.log(res);
      this.staffs = res.data;
    }).catch((error) => {
      router.push('/admin/login');
      localStorage.clear()

      toast.fire({
        icon: "error",
        title: error.response.data.message
      })
    })
    
  },
  mounted(){
            $(document).on('click','#edit',function(){
                let id = $(this).data('id');
                router.push("/admin/staffs/edit/" + id);
            })
            $(document).on('click','#delete',function(){
                let id = $(this).data('id');
                router.push("/admin/staffs/edit/" + id);
            })
        },
  methods: {
   
  
    deleteStaff(index) {
      axios.delete("/api/staffs/" + index, {
        headers: {
          "Content-Type": "application/json",
          Authorization: "Bearer " +store.getters.getAdminToken,
        },
      }).then((res) => {
        this.staffs = this.staffs.filter(staffs => {
          return staffs.id != index
        })
        router.push("/admin/staff-details");
        console.log(res);
      });
    },
  },
};
</script>