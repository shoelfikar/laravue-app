<template>
  <div class="container-fluid mt-3">
    <router-link to="/addbank" class="btn btn-primary mb-3"><i class="fa fa-pencil" aria-hidden="true"></i>Add Bank</router-link>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Data Bank</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Bank Name</th>
                <th>Contact Email</th>
                <th>Logo</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(bank, index) in allBank" :key="bank.id">
                <td>{{index + 1}}</td>
                <td>{{bank.bank_name}}</td>
                <td>{{bank.contact_email}}</td>
                <td>
                  <img :src="`${serverPath}/storage/${bank.logo}`" :alt="bank.bank_name" width="100">
                </td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary mr-2 col-sm-4" @click="getEditData(bank)">Edit</button>
                  <button type="button" class="btn btn-sm btn-danger col-sm-4" @click="deleteBank(bank)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
  export default {
    name: 'Table',
    data() {
      return {
        allBank: [],
        serverPath: 'http://localhost:8000'
      }
    },
    methods: {
      getAllBank() {
        axios.get('http://localhost:8000/api/bank')
          .then(res => {
            this.allBank = res.data
          })
          .catch(err => {
            console.log(err)
          })
      },
      getEditData(data) {
        this.$store.dispatch('getBankData', data)
        this.$router.push(`/editbank/${data.id}`)
      },
      deleteBank(data) {
        Swal.fire({
          text: `Are you sure for delete ${data.bank_name} ?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete!'
        }).then((result) => {
          if (result.value) {
            axios.delete(`http://localhost:8000/api/bank/${data.id}`)
            .then(res => {
              console.log(res)
              Swal.fire(
                'Deleted!',
                'Data Bank has been deleted.',
                'success'
              )
              this.getAllBank()
            })
            .catch(err => {
              console.log(err)
            })
          }
        })
      }
    },
    mounted() {
      this.getAllBank()
    }
  }
</script>
