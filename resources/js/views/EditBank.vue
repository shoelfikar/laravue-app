<template>
    <div class="container d-flex justify-content-center col-md-6 mt-5">
      <div class="card shadow w-100">
        <div class="card-header">
          Edit Data Bank
        </div>
        <div class="card-body">
          <form @submit.prevent="editBank">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-form-label">Bank Name</label>
              <div class="col-sm-9">
                <input type="text" :class="[error.bank_name ? 'form-control is-invalid': 'form-control']" id="validationCustom03" v-model="newData.bank_name">
                <small class="text-danger" v-if="error.bank_name">{{error.bank_name[0]}}</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" :class="[error.email ? 'form-control is-invalid': 'form-control']" id="inputPassword3" v-model="newData.contact_email">
                <small class="text-danger" v-if="error.email">{{error.email[0]}}</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="logo" class="col-sm-3 col-form-label">Logo</label>
              <div class="col-sm-9">
                <div class="custom-file mb-3">
                  <input type="file" :class="[error.logo ? 'custom-file-input is-invalid' : 'custom-file-input']" ref="editBank" id="logo" @change="changeImage" >
                  <label class="custom-file-label overflow-hidden" for="validatedCustomFile">{{newData.logo}}</label>
                  <label class="custom-file-label overflow-hidden" for="validatedCustomFile" v-if="newData.logo.name">{{newData.logo.name}}</label>
                  <div class="invalid-feedback" v-if="error.logo">{{error.logo[0]}}</div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10 mt-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check mr-2" aria-hidden="true"></i>Edit</button>
                <router-link to="/" class="btn btn-dark ml-2"><i class="fa fa-chevron-left mr-2" aria-hidden="true"></i>Back</router-link>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import Swal from 'sweetalert2';
  export default {
    name: 'EditBank',
    props: ['id'],
    data() {
      return {
        newData: {},
        error: {}
      }
    },
    computed: {
      ...mapState(['bankEdit'])
    },
    methods: {
      changeImage() {
        this.newData.logo = this.$refs.editBank.files[0]
      },
      editBank() {
        let formData = new FormData();
        formData.append('bank_name', this.bankEdit.bank_name );
        formData.append('email', this.bankEdit.contact_email)
        formData.append('logo', this.bankEdit.logo || this.bankEdit.logo)
        formData.append('_method', 'put')

        axios.post(`http://localhost:8000/api/bank/${this.bankEdit.id}`,formData)
          .then(res => {
            console.log(res)
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Data Bank Successfully update!',
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
    },
    mounted() {
      this.newData = this.bankEdit;
    }
  }
</script>
