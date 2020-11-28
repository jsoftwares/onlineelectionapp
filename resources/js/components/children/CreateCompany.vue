<template>
<div>

  <!-- Modal: modalPoll -->
    <div class="modal fade right" id="createCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="false">
      <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
          <div class="modal-content">
            <form action="" method="post" @submit.prevent="editing ? updateCompany(): storeCompany()" @keydown="errors.clear($event.target.name)">
              <!--Header-->
              <div class="modal-header">
                  <p class="heading lead">Create Company
                  </p>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">×</span>
                  </button>
              </div>

              <!--Body-->
              <div class="modal-body">
                  <div class="text-center">
                  <i class="far fa-file-alt fa-4x mb-3 animated rotateIn"></i>
                  <p>
                      <strong>Fill in details.</strong>
                  </p>
                  </div>

                  <hr>
              
                  <div class="col-10 col-md-12 pr-0">
                  <!-- Name input -->
                  <div class="md-form">
                    <input name="name" id="mce-NAME" v-model="company.name" type="text" class="form-control required" aria-required="true" required>
                    <label for="mce-NAME" class="">Name</label>
                    <span class="help text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                  </div>

                </div>
              <!-- SHORT NAME -->
                <div class="col-10 col-md-12 pr-0">
                  <!-- Name input -->
                  <div class="md-form">
                    <input name="short_name" id="mce-SHORTNAME" v-model="company.short_name" type="text" class="form-control">
                    <label for="mce-NAME" class="">Short Name</label>
                    <span class="help text-danger" v-if="errors.has('short_name')" v-text="errors.get('short_name')"></span>
                  </div>

                </div>
                <!-- EMAIL -->
                  <div class="col-10 col-md-12 pr-0">
                  <!-- Email input -->
                  <div class="md-form"  v-show="!editing">
                    <input name="email" id="mce-EMAIL" v-model="company.email" type="email" class="form-control">
                    <label for="mce-EMAIL" class="">Email</label>
                    <span class="help text-danger" v-if="errors.has('email')" v-text="errors.get('email')"></span>
                  </div>

                </div>

                <!-- PHONE -->
                <div class="col-10 col-md-12 pr-0">
                  <!-- Name input -->
                  <div class="md-form">
                    <input name="phone" id="mce-PHONE" v-model="company.phone" type="number" class="form-control">
                    <label for="mce-NAME" class="">Phone</label>
                    <span class="help text-danger" v-if="errors.has('phone')" v-text="errors.get('phone')"></span>
                  </div>

                </div>
                
              </div>

              <!--Footer-->
              <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-primary waves-effect waves-light" v-if="editing">Update
                  <i class="fa fa-paper-plane ml-1"></i>
                </button>
                <button type="buton" class="btn btn-primary waves-effect waves-light" :disabled="errors.any()" v-else>Create
                  <i class="fa fa-paper-plane ml-1"></i>
                </button>
                <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
              </div>
            </form>
      </div>
    </div>
  </div>
  <!-- Modal: modalCompany -->

</div>
</template>

<script>

class Errors {
    constructor() {
      this.errors = {};
    }

    any() {
      return Object.keys(this.errors).length > 0;
    }

    get(field) {
      if (this.errors[field]) {
        return this.errors[field][0];
      }
    }

    has(field) {
      return this.errors.hasOwnProperty(field)
    }

    record(errors){
      this.errors = errors;
    }

    clear(field) {
      delete this.errors[field];
    }

  }

  class Company {
    constructor(company) {
      this.id = company.id || null,
      this.name = company.name || '',
      this.short_name = company.short_name || '';
      this.email = company.email || '',
      this.phone = company.phone || ''
    }
  }

export default {
  mounted() {

    this.$parent.$on('createNewCompany', () => {
      this.editing = false,
      this.company = new Company({});
      $('#createCompany').modal();
    })


  },

  data() {
    return {
      company: {},
      errors: new Errors(),
      editing: false
    }
  },

  methods: {
    storeCompany() {
      axios.post('/company', this.company)
      .then( response => {
        this.$parent.$emit('companyCreated', response.data);
        $('#createCompany').modal('hide');
      }).catch((err) => {
        this.errors.record(err.response.data.errors);
      });
    }
  }
 
}
</script>