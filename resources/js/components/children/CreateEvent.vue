<template>
    <div>

    <!-- Modal: modalPoll -->
        <div class="modal fade right" id="createEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
            <div class="modal-content">
                <form action="" method="post" @submit.prevent="editing ? updateEvent(): storeEvent()" @keydown="errors.clear($event.target.name)">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Create Event
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
                    <!-- TITLE -->
                    <div class="col-10 col-md-12 pr-0">

                    <div class="md-form">
                        <input name="title" id="mce-TITLE" v-model="event.title" type="text" class="form-control required" aria-required="true" required>
                        <label for="mce-TITLE" class="">Title</label>
                        <span class="help text-danger" v-if="errors.has('title')" v-text="errors.get('title')"></span>
                    </div>

                    </div>
                <!-- SHORT TITLE -->
                    <div class="col-10 col-md-12 pr-0">
                    <div class="md-form">
                        <input name="short_title" id="mce-SHORTTITLE" v-model="event.short_title" type="text" class="form-control">
                        <label for="mce-SHORTTITLE" class="">Short Title</label>
                        <span class="help text-danger" v-if="errors.has('short_title')" v-text="errors.get('short_title')"></span>
                    </div>

                    </div>
                    <!-- COMPANY -->
                    <div class="col-10 col-md-12 pr-0">
                    <div class="md-formn">
                        <select v-model="event.company_id" class="mdb-select md-form form-control required" aria-required="true" required>
                            <option value="" disabled selected>Choose company</option>
                            <option v-for="(company, index) in companies" :key="index" :value="company.id">{{company.name}}</option>
                        </select>
                        <!-- <label for="mce-COMPANY" class="">Company</label> -->
                        <span class="help text-danger" v-if="errors.has('short_title')" v-text="errors.get('short_title')"></span>
                    </div>

                    </div>
                    <!-- VENUE -->
                    <div class="col-10 col-md-12 pr-0">
                        <div class="md-form">
                            <textarea name="venue" id="form7" v-model="event.venue" class="md-textarea form-control" rows="3"></textarea>
                            <label for="form7">Venue</label>
                            <span class="help text-danger" v-if="errors.has('venue')" v-text="errors.get('venue')"></span>
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
    <!-- Modal: modalEvent -->

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

  class Event {
    constructor(event) {
      this.id = event.id || null,
      this.title = event.title || '',
      this.short_title = event.short_title || '';
      this.venue = event.venue || ''
    }
  }

export default {
  mounted() {

        this.$parent.$on('createNewEvent', (companies) => {
        this.editing = false,
        this.companies = companies;
        this.event = new Event({});
        $('#createEvent').modal();
    })


  },

  data() {
    return {
      event: {},
      companies: [],
      errors: new Errors(),
      editing: false
    }
  },

  methods: {
    storeEvent() {
      axios.post('/event', this.event)
      .then( response => {
        this.$parent.$emit('eventCreated', response.data);
        $('#createEvent').modal('hide');
      }).catch((err) => {
        this.errors.record(err.response.data.errors);
      });
    }
  }
 
}
</script>