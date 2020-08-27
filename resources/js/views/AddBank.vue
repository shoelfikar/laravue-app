<template>
  <div class="container d-flex justify-content-center col-md-6 mt-5">
    <div class="card shadow w-100">
      <div class="card-header">
        Add New Bank
      </div>
      <div class="card-body">
        <form @submit.prevent="createBank">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Bank Name</label>
            <div class="col-sm-9">
              <input type="text" :class="[error.bank_name ? 'form-control is-invalid': 'form-control']" id="validationCustom03" v-model="bankData.bank_name">
              <small class="text-danger" v-if="error.bank_name">{{error.bank_name[0]}}</small>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="text" :class="[error.email ? 'form-control is-invalid': 'form-control']" id="inputPassword3" v-model="bankData.email">
              <small class="text-danger" v-if="error.email">{{error.email[0]}}</small>
            </div>
          </div>
          <div class="form-group row">
            <label for="logo" class="col-sm-3 col-form-label">Logo</label>
            <div class="col-sm-9">
              <div class="custom-file mb-3">
                <input type="file" :class="[error.logo ? 'custom-file-input is-invalid' : 'custom-file-input']" ref="logoBank" id="logo" @change="changeImage">
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <label class="custom-file-label" for="validatedCustomFile" v-if="bankData.logo.name">{{bankData.logo.name}}</label>
                <div class="invalid-feedback" v-if="error.logo">{{error.logo[0]}}</div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10 mt-2">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check mr-2" aria-hidden="true"></i>Add</button>
              <router-link to="/" class="btn btn-dark ml-2"><i class="fa fa-chevron-left mr-2" aria-hidden="true"></i>Back</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from'axios';
import swal from 'sweetalert2';
  export default {
    name: 'AddBank',
    data() {
      return {
        bankData: {
          bank_name: '',
          email: '',
          logo: ''
        },
        error: {}
      }
    },
    methods: {
      changeImage() {
        this.bankData.logo = this.$refs.logoBank.files[0]
        console.log(this.bankData.logo)
      },
      createBank() {
        let formData = new FormData();
        formData.append('bank_name', this.bankData.bank_name);
        formData.append('email', this.bankData.email)
        formData.append('logo', this.bankData.logo)

        axios.post('http://localhost:8000/api/bank',formData,{
          headers:{
            'Content-Type' : 'multipart/form-data'
          }
        })
          .then(res => {
            console.log(res)
            swal.fire({
              icon: 'success',
              html: 'Create Data Bank Success!',
              showConfirmButton: false,
              timer: 3000
            })
            this.$router.push('/')
          })
          .catch(error => {
            switch (error.response.status) {
              case 422:
                this.error = error.response.data.errors;
                break;
            
              default:
                this.error = error.response.data.errors;
                break;
            }
            console.log(this.error)
          })
      }
    }
  }
</script>